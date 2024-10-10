<?php

namespace App\Http\Controllers;

use App\Http\Controllers\bases\FacturacionBaseController;
use App\Http\Resources\TicketFactura\TicketFacturaResource;
use App\Mail\FacturaMailable;
use App\Models\AppMailer;
use App\Models\ErrorLog;
use App\Models\Factura;
use App\Models\FacturaTemporal;
use DOMDocument;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use SimpleXMLElement;
use SoapClient;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Config;

class FacturaController extends FacturacionBaseController
{
    public function GenerarFactura(Request $request){
        $id = $request->input('id_factura');
        $factura_temporal = FacturaTemporal::findOrFail($id);
        $factura_temporal->xml = $this->getXML($factura_temporal);
        FacturaTemporal::where('id', $factura_temporal->id)
        ->update(['xml' => $factura_temporal->xml]);
        
        if(env('APP_ENV', 'local') === 'production'){
            $dataResponse = $this->TimbrarCFDI($factura_temporal);
        }else{
            $dataResponse = $this->TimbrarDEMO($factura_temporal);
        }

        if($dataResponse["success"] == true){
            $factura = self::guardarFacturaDB($factura_temporal, $dataResponse);
            $dataResponse['id'] = $factura->id;
            $this->enviarCorreo($factura);
        }

        return response()->json($dataResponse);
    }

    public static function GenerarFacturaV2(FacturaTemporal $factura_temporal){
        $factura_temporal->xml = FacturaController::getXML($factura_temporal);
	    FacturaTemporal::where('id', $factura_temporal->id)->update(['xml' => $factura_temporal->xml]);
        if(env('APP_ENV', 'local') === 'production'){
            $response = FacturaController::TimbrarCFDI($factura_temporal);
        }else{
            $response = FacturaController::TimbrarDEMO($factura_temporal);
        }

        if($response["success"] == true){
            $factura = self::guardarFacturaDB($factura_temporal, $response);
            $factura->createAndSavePDF();
            $response['factura_id'] = $factura->id;
            return $response;
        }
        return $response;
    }

    public static function enviarCorreo(Factura $factura, $correo = null){
        try{
            // $mailer = AppMailer::where('id', 1)->first();
            // Config::set('mail.transport', $mailer->mailer);
            // Config::set('mail.host', $mailer->host);
            // Config::set('mail.port', $mailer->port);
            // Config::set('mail.username', $mailer->username);
            // Config::set('mail.password', $mailer->password);
            
            // $mail = $correo == null ? $factura->entidad_fiscal->correo : $correo;
            // $mailable = new FacturaMailable($factura);
            // Mail::to($mail)->send($mailable);
            return true;
        }
        catch(Exception $e){
            ErrorLog::create(['titulo' => 'EnviarCorreo', 'error' => $e->getMessage()]);
        }
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
                    'message' => 'Se ha generado factura',
                    'uuid' => $result->Timbre->UUID,
                    'xml' => $result->XMLResultado,
                    'data' => json_encode($result),
                ];
            }

            $error = $result->CodigoRespuesta . ' - ' . $result->MensajeError . ' - ' . $result->MensajeErrorDetallado;
            ErrorLog::create(['titulo' => 'TimbrarFactura', 'error' => $error, 'data' => json_encode($result)]);

            return [
                'success' => false,
                'message' => $error,
                'codigo_respuesta' => $result->CodigoRespuesta,
                'mensaje_error' => $result->MensajeError,
                'mensaje_error_detallado' => $result->MensajeErrorDetallado,
                'data' => json_encode($result),
            ];
            
        } catch (\Exception $ex) {
            ErrorLog::create(['titulo' => 'TimbrarFactura', 'error' => $ex->getMessage()]);
            return response($ex->getMessage(), 500);
        }
    }

    public static function guardarFacturaDB($factura_temporal, &$response){
        try{
            $factura = new Factura();
            $factura->sucursal_id = Auth::user()->sucursal_default;
            $factura->usuario_id = $factura_temporal->usuario_id;
            $factura->emisor_id = $factura_temporal->sucursal->emisor_id;
            $factura->entidad_fiscal_id = $factura_temporal->entidad_fiscal_id;
            $factura->model_id = $factura_temporal->model_id;
            $factura->model_type = $factura_temporal->model_type;
            $factura->tasa_iva = $factura_temporal->tasa_iva;
            $factura->tipo = $factura_temporal->tipo_comprobante;
            $factura->forma_pago = $factura_temporal->forma_pago;
            $factura->serie = $factura_temporal->sucursal->emisor->serie;
            $factura->folio = $factura_temporal->folio;
            $factura->subtotal = $factura_temporal->total();
            $factura->total = $factura_temporal->total_c_iva;
            $factura->uuid = $response['uuid'];
            $factura->xml = $response['xml'];
            $factura->estatus = 'TIMBRADO';
            if($factura->save()){
                $factura->emisor->folio_facturas++;
                $factura->emisor->save();
                $response['id'] = $factura->id;
                $response['folio'] = $factura->folio;
                $response['serie'] = $factura->serie;
            }



            return $factura;

        } catch (\Exception $ex) {
            echo $ex->getMessage();
            return 0;
        }
    }

    public function getXMLANTERIOR($factura_t){
        $xmlHeader = '<?xml version="1.0" encoding="UTF-8"?>';
        $xmlHeader .= '<cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd">';
        $xmlHeader .= '</cfdi:Comprobante>';

        $emisor = $factura_t->sucursal->emisor;
        $receptor = $factura_t->entidad_fiscal;

        $factura_t->folio = $emisor->folio_facturas;

        $CFDI_xml = new SimpleXMLElement($xmlHeader);
        $CFDI_xml->addAttribute('Version', '4.0');
        $CFDI_xml->addAttribute('Serie', $emisor->serie);
        $CFDI_xml->addAttribute('Folio', $factura_t->folio);
        $CFDI_xml->addAttribute('Fecha', date('Y-m-d\TH:i:s'));
        $CFDI_xml->addAttribute('NoCertificado', $emisor->no_certificado);
        $CFDI_xml->addAttribute('Certificado', base64_encode($emisor->cer));
        $CFDI_xml->addAttribute('SubTotal', number_format($factura_t->total(), 2, '.', ''));
        $CFDI_xml->addAttribute('Moneda','MXN');
        $CFDI_xml->addAttribute('Total', number_format($factura_t->total_c_iva, 2, '.', ''));
        $CFDI_xml->addAttribute('TipoDeComprobante', $factura_t->tipo_comprobante);
        $CFDI_xml->addAttribute('FormaPago', $factura_t->forma_pago);
        $CFDI_xml->addAttribute('MetodoPago', $factura_t->metodo_pago);
        $CFDI_xml->addAttribute('LugarExpedicion', $emisor->lugar_expedicion);
        $CFDI_xml->addAttribute('Exportacion', $factura_t->exportacion);

        $CFDI_Emisor = $CFDI_xml->addChild("cfdi:Emisor");
        $CFDI_Emisor->addAttribute('Nombre', $emisor->nombre);
        $CFDI_Emisor->addAttribute('Rfc', $emisor->rfc);
        $CFDI_Emisor->addAttribute('RegimenFiscal', $emisor->regimen_fiscal);

        $CFDI_Receptor = $CFDI_xml->addChild("cfdi:Receptor");
        $CFDI_Receptor->addAttribute('Nombre', $receptor->razon_social);
        $CFDI_Receptor->addAttribute('Rfc', $receptor->rfc);
        $CFDI_Receptor->addAttribute('DomicilioFiscalReceptor', strval($receptor->cp));
        $CFDI_Receptor->addAttribute('RegimenFiscalReceptor', $receptor->regimen_fiscal);
        $CFDI_Receptor->addAttribute('UsoCFDI', $factura_t->uso_cfdi);

        $CFDI_Conceptos = $CFDI_xml->addChild("cfdi:Conceptos");
        foreach ($factura_t->conceptos as $elem)
        {
            $CFDI_Concepto = $CFDI_Conceptos->addChild('cfdi:Concepto');
            $CFDI_Concepto->addAttribute('ClaveUnidad', $elem->clave_unidad);
            $CFDI_Concepto->addAttribute('ClaveProdServ', $elem->clave_prod_serv);
            $CFDI_Concepto->addAttribute('NoIdentificacion', $elem->no_identificacion);
            $CFDI_Concepto->addAttribute('Cantidad', number_format($elem->cantidad, 2, '.', ''));
            $CFDI_Concepto->addAttribute('Descripcion', $elem->descripcion);
            $CFDI_Concepto->addAttribute('ValorUnitario', number_format($elem->valor_unitario_final, 2, '.', ''));
            $CFDI_Concepto->addAttribute('Importe', number_format($elem->importe(), 2, '.', ''));
            $CFDI_Concepto->addAttribute('ObjetoImp', $elem->objeto_imp);

            if($elem->objeto_imp == '02'){
                $CFDI_Impuestos = $CFDI_Concepto->addChild('cfdi:Impuestos');
                $CFDI_Traslados = $CFDI_Impuestos->addChild('cfdi:Traslados');
                $CFDI_Traslado = $CFDI_Traslados->addChild('cfdi:Traslado');
                $CFDI_Traslado->addAttribute('Base', number_format($elem->importe(), 2, '.', ''));
                $CFDI_Traslado->addAttribute('Impuesto', '002');
                $CFDI_Traslado->addAttribute('TipoFactor', 'Tasa');
                $CFDI_Traslado->addAttribute('TasaOCuota', '0.160000');
                $CFDI_Traslado->addAttribute('Importe', number_format($elem->iva, 2, '.', ''));
            }

        }

        $CFDI_Impuestos = $CFDI_xml->addChild("cfdi:Impuestos");
        $CFDI_Impuestos->addAttribute('TotalImpuestosTrasladados', number_format($factura_t->iva, 2, '.', ''));
        $CFDI_Traslados = $CFDI_Impuestos->addChild("cfdi:Traslados");
        $CFDI_Traslado = $CFDI_Traslados->addChild("cfdi:Traslado");
        $CFDI_Traslado->addAttribute('Base', $factura_t->total());
        $CFDI_Traslado->addAttribute('Impuesto', '002');
        $CFDI_Traslado->addAttribute('TipoFactor', 'Tasa');
        $CFDI_Traslado->addAttribute('TasaOCuota', '0.160000');
        $CFDI_Traslado->addAttribute('Importe', number_format($factura_t->iva, 2, '.', ''));

        ////////////////// S E L L A R    C F D I //////////////////
        
        $CFDI_xml->addAttribute('Sello',$this->generarSello($CFDI_xml, $emisor));
        return $CFDI_xml->asXML();
    }

    public static function getXML($factura_t){
        $xmlHeader = '<?xml version="1.0" encoding="UTF-8"?>';
        $xmlHeader .= '<cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd">';
        $xmlHeader .= '</cfdi:Comprobante>';

        $emisor = $factura_t->sucursal->emisor;
        $receptor = $factura_t->entidad_fiscal;

        $factura_t->folio = $emisor->folio_facturas;

        $CFDI_xml = new SimpleXMLElement($xmlHeader);
        $CFDI_xml->addAttribute('Version', '4.0');
        $CFDI_xml->addAttribute('Serie', $emisor->serie);
        $CFDI_xml->addAttribute('Folio', $factura_t->folio);
        $CFDI_xml->addAttribute('Fecha', date('Y-m-d\TH:i:s'));
        $CFDI_xml->addAttribute('NoCertificado', $emisor->no_certificado);
        $CFDI_xml->addAttribute('Certificado', base64_encode($emisor->cer));
        $CFDI_xml->addAttribute('SubTotal', number_format($factura_t->total(), 2, '.', ''));
        $CFDI_xml->addAttribute('Moneda','MXN');
        $CFDI_xml->addAttribute('Total', number_format($factura_t->total_c_iva(), 2, '.', ''));
        $CFDI_xml->addAttribute('TipoDeComprobante', $factura_t->tipo_comprobante);
        $CFDI_xml->addAttribute('FormaPago', str_pad($factura_t->forma_pago, 2, "0", STR_PAD_LEFT));
        $CFDI_xml->addAttribute('MetodoPago', $factura_t->metodo_pago);
        $CFDI_xml->addAttribute('LugarExpedicion', $emisor->lugar_expedicion);
        $CFDI_xml->addAttribute('Exportacion', $factura_t->exportacion);

        if($receptor->rfc == 'XAXX010101000'){
            $data = json_decode($factura_t->comentarios);
            $periocidad = $data->periocidad;
            $meses = $data->meses;
            $anio = trim($data->anio);
            
            $CFDI_Emisor = $CFDI_xml->addChild("cfdi:InformacionGlobal");
            $CFDI_Emisor->addAttribute('Periodicidad', $periocidad);
            $CFDI_Emisor->addAttribute('Meses', $meses);
            $CFDI_Emisor->addAttribute('Año', $anio);
        }

        $CFDI_Emisor = $CFDI_xml->addChild("cfdi:Emisor");
        $CFDI_Emisor->addAttribute('Nombre', $emisor->nombre);
        $CFDI_Emisor->addAttribute('Rfc', $emisor->rfc);
        $CFDI_Emisor->addAttribute('RegimenFiscal', $emisor->regimen_fiscal);

        $CFDI_Receptor = $CFDI_xml->addChild("cfdi:Receptor");
        $CFDI_Receptor->addAttribute('Nombre', $receptor->razon_social);
        $CFDI_Receptor->addAttribute('Rfc', $receptor->rfc);
        $CFDI_Receptor->addAttribute('DomicilioFiscalReceptor', strval($receptor->cp));
        $CFDI_Receptor->addAttribute('RegimenFiscalReceptor', $receptor->regimen_fiscal);
        $CFDI_Receptor->addAttribute('UsoCFDI', $factura_t->uso_cfdi);

        $CFDI_Conceptos = $CFDI_xml->addChild("cfdi:Conceptos");
        foreach ($factura_t->conceptos as $elem)
        {
            $CFDI_Concepto = $CFDI_Conceptos->addChild('cfdi:Concepto');
            $CFDI_Concepto->addAttribute('ClaveUnidad', $elem->clave_unidad);
            $CFDI_Concepto->addAttribute('ClaveProdServ', $elem->clave_prod_serv);
            $CFDI_Concepto->addAttribute('NoIdentificacion', $elem->no_identificacion);
            $CFDI_Concepto->addAttribute('Cantidad', number_format($elem->cantidad, 2, '.', ''));
            $CFDI_Concepto->addAttribute('Descripcion', $elem->descripcion);
            $CFDI_Concepto->addAttribute('ValorUnitario', number_format($elem->valor_unitario_final, 2, '.', ''));
            $CFDI_Concepto->addAttribute('Importe', number_format($elem->importe(), 2, '.', ''));
            $CFDI_Concepto->addAttribute('ObjetoImp', $elem->objeto_imp);

            if($elem->objeto_imp == '02'){
                $CFDI_Impuestos = $CFDI_Concepto->addChild('cfdi:Impuestos');
                $CFDI_Traslados = $CFDI_Impuestos->addChild('cfdi:Traslados');
                $CFDI_Traslado = $CFDI_Traslados->addChild('cfdi:Traslado');
                $CFDI_Traslado->addAttribute('Base', number_format($elem->importe(), 2, '.', ''));
                $CFDI_Traslado->addAttribute('Impuesto', '002');
                $CFDI_Traslado->addAttribute('TipoFactor', 'Tasa');
                $CFDI_Traslado->addAttribute('TasaOCuota', number_format(($factura_t->tasa_iva / 100), 6, '.', ''));
                $CFDI_Traslado->addAttribute('Importe', number_format($elem->iva(), 2, '.', ''));
            }

        }

        $CFDI_Impuestos = $CFDI_xml->addChild("cfdi:Impuestos");
        $CFDI_Impuestos->addAttribute('TotalImpuestosTrasladados', number_format($factura_t->iva(), 2, '.', ''));
        $CFDI_Traslados = $CFDI_Impuestos->addChild("cfdi:Traslados");
        $CFDI_Traslado = $CFDI_Traslados->addChild("cfdi:Traslado");
        $CFDI_Traslado->addAttribute('Base', $factura_t->total());
        $CFDI_Traslado->addAttribute('Impuesto', '002');
        $CFDI_Traslado->addAttribute('TipoFactor', 'Tasa');
        $CFDI_Traslado->addAttribute('TasaOCuota', number_format(($factura_t->tasa_iva / 100), 6, '.', ''));
        $CFDI_Traslado->addAttribute('Importe', number_format($factura_t->iva(), 2, '.', ''));

        ////////////////// S E L L A R    C F D I //////////////////
        
        $CFDI_xml->addAttribute('Sello', self::generarSello($CFDI_xml, $emisor));
        return $CFDI_xml->asXML();
    }

    public static function getXmlToPDFResource(Factura $factura){
        $xml = $factura->xml;
        $xml = simplexml_load_string($xml);
        return new TicketFacturaResource($xml);
    }

    //////////// F A C T U R A C I O N ////////////
    public static function factura_pdf(Factura $factura){
        $cfdi = FacturaController::getXmlToPDFResource($factura);        
        $pdf = PDF::loadView('pdf.facturacion.factura_pdf', ['cfdi' => collect($cfdi)]);
        $pdf->setPaper('A4');
        return $pdf->stream($factura->uuid . '.pdf');
    }
    
    public static function downloadXML(Factura $factura){
        return response($factura->xml)
        ->header('Content-type', 'text/xml')
        ->header('Content-Disposition', 'attachment; filename="' . $factura->uuid . '.xml"');
    }

}
