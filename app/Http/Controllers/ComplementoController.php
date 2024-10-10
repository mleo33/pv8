<?php

namespace App\Http\Controllers;

use App\Classes\FacturacionConstants;
use App\Http\Controllers\bases\FacturacionBaseController;
use App\Mail\ComplementoMailable;
use App\Models\Complemento;
use App\Models\ErrorLog;
use App\Models\Factura;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use SimpleXMLElement;
use SoapClient;
use Barryvdh\DomPDF\Facade as PDF;
use stdClass;

class ComplementoController extends FacturacionBaseController
{
    public static function enviarCorreo($complemento, $correo = null){
        try{
            $mail = $correo == null ? $complemento->entidad_fiscal->correo : $correo;
            $mailable = new ComplementoMailable($complemento);
            Mail::to($mail)->send($mailable);
        }
        catch(Exception $e){
            ErrorLog::create(['titulo' => 'EnviarCorreo', 'error' => $e->getMessage()]);
        }
    }

    public function GenerarComplemento(Request $request){
        $data = $request->input();
        $factura = Factura::findOrFail($data['factura_id']);

        $complemento = new Complemento();
        $complemento->sucursal_id = Auth::user()->sucursal_default;
        $complemento->monto = $data["Monto"];
        $complemento->forma_pago = FacturacionConstants::FORMAS_PAGO[$data['FormaDePagoP']];
        $complemento->xml = ComplementoController::getXML($data, $complemento, $factura);

        if(env('APP_ENV', 'local') == 'production'){
            $dataResponse = ComplementoController::TimbrarCFDI($complemento);
        }else{
            $dataResponse = ComplementoController::TimbrarComplementoDEMO($complemento);
        }


        if($dataResponse["success"] == true){
            ComplementoController::guardarFacturaDB($complemento, $factura, $dataResponse);
            ComplementoController::enviarCorreo($complemento);
        }

        return response()->json($dataResponse);
    }

    public static function getXML($data, $complemento, $factura){
        $xmlHeader = '<?xml version="1.0" encoding="UTF-8"?>';
        $xmlHeader .= '<cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd">';
        $xmlHeader .= '</cfdi:Comprobante>';

        $emisor = $complemento->sucursal->emisor;
        $receptor = $factura->entidad_fiscal;
        $folio_factura = $emisor->folio_complementos;

        $CFDI_xml = new SimpleXMLElement($xmlHeader);
        $CFDI_xml->addAttribute('Version', '4.0');
        $CFDI_xml->addAttribute('Serie', $emisor->serie_complementos);
        $CFDI_xml->addAttribute('Folio', $folio_factura);
        $CFDI_xml->addAttribute('Fecha', date('Y-m-d\TH:i:s'));
        $CFDI_xml->addAttribute('NoCertificado', $emisor->no_certificado);
        $CFDI_xml->addAttribute('Certificado', base64_encode($emisor->cer));
        $CFDI_xml->addAttribute('SubTotal', 0);
        $CFDI_xml->addAttribute('Moneda','XXX');
        $CFDI_xml->addAttribute('Total', 0);
        $CFDI_xml->addAttribute('TipoDeComprobante', 'P');
        $CFDI_xml->addAttribute('LugarExpedicion', $emisor->lugar_expedicion);
        $CFDI_xml->addAttribute('Exportacion', '01');

        $CFDI_Emisor = $CFDI_xml->addChild("cfdi:Emisor");
        $CFDI_Emisor->addAttribute('Nombre', $emisor->nombre);
        $CFDI_Emisor->addAttribute('Rfc', $emisor->rfc);
        $CFDI_Emisor->addAttribute('RegimenFiscal', $emisor->regimen_fiscal);

        $CFDI_Receptor = $CFDI_xml->addChild("cfdi:Receptor");
        $CFDI_Receptor->addAttribute('Nombre', $receptor->razon_social);
        $CFDI_Receptor->addAttribute('Rfc', $receptor->rfc);
        $CFDI_Receptor->addAttribute('DomicilioFiscalReceptor', strval($receptor->cp));
        $CFDI_Receptor->addAttribute('RegimenFiscalReceptor', $receptor->regimen_fiscal);
        $CFDI_Receptor->addAttribute('UsoCFDI', "CP01");

        $CFDI_Conceptos = $CFDI_xml->addChild("cfdi:Conceptos");
        $CFDI_Concepto = $CFDI_Conceptos->addChild('cfdi:Concepto');
        $CFDI_Concepto->addAttribute('ClaveUnidad', 'ACT');
        $CFDI_Concepto->addAttribute('ClaveProdServ', '84111506');
        $CFDI_Concepto->addAttribute('Cantidad', 1);
        $CFDI_Concepto->addAttribute('Descripcion', 'Pago');
        $CFDI_Concepto->addAttribute('ValorUnitario', 0);
        $CFDI_Concepto->addAttribute('Importe', 0);
        $CFDI_Concepto->addAttribute('ObjetoImp', '01');
        //////////// CONCEPTOS ////////////

        $CFDI_Complemento = $CFDI_xml->addChild("cfdi:Complemento");
        $CFDI_Pagos = $CFDI_Complemento->addChild("pago20:Pagos", null, self::URI_PAGOS);
        $CFDI_Pagos->addAttribute('Version', '2.0');

        $CFDI_Totales = $CFDI_Pagos->addChild("pago20:Totales", null, self::URI_PAGOS);
        $CFDI_Totales->addAttribute('MontoTotalPagos', number_format($data['Monto'], 2, '.', ''));


        $base = (floatval($data['Monto']) / ( 1 + ($factura->tasa_iva / 100)));
        $iva = (floatval($base) * ($factura->tasa_iva / 100));

        if($factura->tasa_iva == 16){
            $CFDI_Totales->addAttribute('TotalTrasladosBaseIVA16', number_format($base, 2, '.', ''));
            $CFDI_Totales->addAttribute('TotalTrasladosImpuestoIVA16', number_format($iva, 2, '.', ''));
        }
        else if($factura->tasa_iva == 8){
            $CFDI_Totales->addAttribute('TotalTrasladosBaseIVA8', number_format($base, 2, '.', ''));
            $CFDI_Totales->addAttribute('TotalTrasladosImpuestoIVA8', number_format($iva, 2, '.', ''));
        }

        $CFDI_Pago = $CFDI_Pagos->addChild("pago20:Pago", null, self::URI_PAGOS);
        $CFDI_Pago->addAttribute('FechaPago', $data['FechaPago'] . 'T12:00:00');
        $CFDI_Pago->addAttribute('FormaDePagoP', str_pad($data['FormaDePagoP'], 2, '0', STR_PAD_LEFT));
        $CFDI_Pago->addAttribute('MonedaP', 'MXN');
        $CFDI_Pago->addAttribute('TipoCambioP', '1');
        $CFDI_Pago->addAttribute('Monto', number_format($data['Monto'], 2, '.', ''));

        foreach (['RfcEmisorCtaOrd', 'CtaOrdenante', 'RfcEmisorCtaBen', 'CtaBeneficiario', 'NumOperacion'] as $value) {
            if (array_key_exists($value, $data) && $data[$value]) {
                $CFDI_Pago->addAttribute($value, $data[$value]);
            }
        }
        
        $CFDI_DoctoRelacionado = $CFDI_Pago->addChild("pago20:DoctoRelacionado", null, self::URI_PAGOS);
        $CFDI_DoctoRelacionado->addAttribute('IdDocumento', $factura->uuid);
        $CFDI_DoctoRelacionado->addAttribute('Serie', $factura->serie);
        $CFDI_DoctoRelacionado->addAttribute('Folio', $factura->folio);
        $CFDI_DoctoRelacionado->addAttribute('MonedaDR', 'MXN');
        $CFDI_DoctoRelacionado->addAttribute('ObjetoImpDR', '02');
        $CFDI_DoctoRelacionado->addAttribute('EquivalenciaDR', '1');
        $CFDI_DoctoRelacionado->addAttribute('NumParcialidad', $data['NumParcialidad']);
        $CFDI_DoctoRelacionado->addAttribute('ImpSaldoAnt', number_format($data['ImpSaldoAnt'], 2, '.', ''));
        $CFDI_DoctoRelacionado->addAttribute('ImpPagado', number_format($data['ImpPagado'], 2, '.', ''));
        $CFDI_DoctoRelacionado->addAttribute('ImpSaldoInsoluto', number_format($data['ImpSaldoInsoluto'], 2, '.', ''));

        $CFDI_ImpuestosDR = $CFDI_DoctoRelacionado->addChild("pago20:ImpuestosDR", null, self::URI_PAGOS);
        $CFDI_TrasladosDR = $CFDI_ImpuestosDR->addChild("pago20:TrasladosDR", null, self::URI_PAGOS);
        $CFDI_TrasladoDR = $CFDI_TrasladosDR->addChild("pago20:TrasladoDR", null, self::URI_PAGOS);
        $CFDI_TrasladoDR->addAttribute('BaseDR', number_format($base, 2, '.', ''));
        $CFDI_TrasladoDR->addAttribute('ImpuestoDR', '002');
        $CFDI_TrasladoDR->addAttribute('TipoFactorDR', 'Tasa');
        $CFDI_TrasladoDR->addAttribute('TasaOCuotaDR', number_format(($factura->tasa_iva / 100), 6, '.', ''));
        $CFDI_TrasladoDR->addAttribute('ImporteDR', number_format($iva, 2, '.', ''));

        $CFDI_ImpuestosP = $CFDI_Pago->addChild("pago20:ImpuestosP", null, self::URI_PAGOS);
        $CFDI_TrasladosP = $CFDI_ImpuestosP->addChild("pago20:TrasladosP", null, self::URI_PAGOS);
        $CFDI_TrasladoP = $CFDI_TrasladosP->addChild("pago20:TrasladoP", null, self::URI_PAGOS);
        $CFDI_TrasladoP->addAttribute('BaseP', number_format($base, 2, '.', ''));
        $CFDI_TrasladoP->addAttribute('ImpuestoP', '002');
        $CFDI_TrasladoP->addAttribute('TipoFactorP', 'Tasa');
        $CFDI_TrasladoP->addAttribute('TasaOCuotaP', number_format(($factura->tasa_iva / 100), 6, '.', ''));
        $CFDI_TrasladoP->addAttribute('ImporteP', number_format($iva, 2, '.', ''));// Cada DoctoRelacionado lleva su nodo de impuestos y en pagos igual nodo de impuestos con somatoria ---> DE MOMENTO AMBOS SON IGUALES, si lleva mas Doctos, se tendra que modificar el codigo

        ////////////////// S E L L A R    C F D I //////////////////
        
        $CFDI_xml->addAttribute('Sello', self::generarSello($CFDI_xml, $emisor));
        return $CFDI_xml->asXML();
    }

    public static function TimbrarCFDI($factura){
        try 
        {
            $emisor = $factura->sucursal->emisor;
            $soapclient = new SoapClient('https://www.foliosdigitalespac.com/WSTimbrado33/WSCFDI33.svc?WSDL'); //PRODUCTION
        
            $params = array('usuario' => $emisor->fd_user, 'password' => $emisor->fd_pass, 'cadenaXML'=> $factura->xml, 'referencia' => $_ENV['APP_NAME']);
            $response = $soapclient->TimbrarCFDI($params);
            $result = $response->TimbrarCFDIResult;

            if($result->OperacionExitosa)
            {
                return [
                    'success' => true,
                    'message' => 'Se ha generado complemento de pago',
                    'uuid' => $result->Timbre->UUID,
                    'xml' => $result->XMLResultado,
                    'data' => json_encode($result),
                ];
            }

            $error = $result->CodigoRespuesta . ' - ' . $result->MensajeError . ' - ' . $result->MensajeErrorDetallado;
            ErrorLog::create(['titulo' => 'TimbrarComplemento', 'error' => $error, 'data' => json_encode($result)]);

            return [
                'success' => false,
                'message' => $error,
                'codigo_respuesta' => $result->CodigoRespuesta,
                'mensaje_error' => $result->MensajeError,
                'mensaje_error_detallado' => $result->MensajeErrorDetallado,
                'data' => json_encode($result),
            ];
            
        } catch (\Exception $ex) {
            ErrorLog::create(['titulo' => 'TimbrarComplemento', 'error' => $ex->getMessage()]);
            return response($ex->getMessage(), 500);
        }
    }

    public function guardarFacturaDB($complemento, $factura, &$response){
        try{
            $complemento->sucursal_id = Auth::user()->sucursal_default;
            $complemento->usuario_id = Auth::user()->id;
            $complemento->emisor_id = $factura->sucursal->emisor_id;
            $complemento->entidad_fiscal_id = $factura->entidad_fiscal_id;
            $complemento->tipo = 'PAGO';
            $complemento->serie = $factura->sucursal->emisor->serie_complementos;
            $complemento->folio = $factura->sucursal->emisor->folio_complementos;
            $complemento->uuid = $response['uuid'];
            $complemento->xml = $response['xml'];
            $complemento->estatus = 'TIMBRADO';
            
            if($complemento->save()){
                $factura->emisor->folio_complementos++;
                $factura->emisor->save();
                $response['id'] = $complemento->id;
                $response['folio'] = $complemento->folio;
                $response['serie'] = $complemento->serie;
                $factura->complementos()->attach($complemento);
            }
            
            return $complemento;

        } catch (\Exception $ex) {
            echo $ex->getMessage();
            return 0;
        }
    }

    public static function complemento_pago_pdf(Complemento $complemento){
        // $xml = $complemento->xml;
        // $xml = simplexml_load_string($xml);
        // $pdf = PDF::loadView('pdf.facturacion.complemento_pago_pdf', compact('factura', 'xml'));
        // $pdf->setPaper('A4', 'Landscape');
        // return $pdf->stream($complemento->uuid . '.pdf');

        $xml = $complemento->xml;
        $xml = simplexml_load_string($xml);
        $regimenes = FacturacionConstants::REGIMENES_FISCALES;
        $tipos_comprobante = FacturacionConstants::TIPOS_COMPROBRANTE;
        $metodos_pago = FacturacionConstants::METODOS_PAGO;
        $formas_pago = FacturacionConstants::FORMAS_PAGO;
        $usos_cfdi = FacturacionConstants::USO_CFDI;
        $pdf = PDF::loadView('pdf.facturacion.complemento_pago_pdf', compact(
            'complemento', 'xml', 'regimenes', 'tipos_comprobante',
            'metodos_pago', 'formas_pago', 'usos_cfdi'
        ));
        $pdf->setPaper('A4');
        
        return $pdf->stream($complemento->uuid . '.pdf');
    }
    
    public static function downloadXML(Complemento $complemento){
        return response($complemento->xml)
        ->header('Content-type', 'text/xml')
        ->header('Content-Disposition', 'attachment; filename="' . $complemento->uuid . '.xml"');
    }
}
