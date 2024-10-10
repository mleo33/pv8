<?php

namespace App\Http\Controllers\bases;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketFactura\TicketFacturaResource;
use App\Models\ErrorLog;
use App\Models\Factura;
use Illuminate\Http\Request;
use DOMDocument;
use SoapClient;
use stdClass;
use XSLTProcessor;

class FacturacionBaseController extends Controller
{
    protected const URI_SAT = "http://www.sat.gob.mx/cfd/4";
    protected const URI_PAGOS = "http://www.sat.gob.mx/Pagos20";

    public static function generarSello($xml, $emisor){
        $private = openssl_pkey_get_private($emisor->key);
        $sig = "";
        $cadenaOriginal = self::getCadenaOriginal($xml);
        openssl_sign($cadenaOriginal, $sig, $private, OPENSSL_ALGO_SHA256);
        $sello = base64_encode($sig);
        return $sello;
    }

    public static function TimbrarDEMO($factura){
        try 
        {
            $result = new stdClass();
            $result->OperacionExitosa = true;
            $result->Timbre = new stdClass();
            $result->Timbre->UUID = '1234-ABCD-9876-5432';
            $result->XMLResultado = $factura->xml;

            $result->CodigoRespuesta = 'CodigoRespuesta';
            $result->MensajeError = 'MensajeError';
            $result->MensajeErrorDetallado = 'MensajeErrorDetallado';

            $result->XMLResultado = '<?xml version="1.0" encoding="UTF-8"?><cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd" Version="4.0" Serie="A" Folio="309" Fecha="2022-12-16T07:40:38" NoCertificado="00001000000505095954" Certificado="MIIF8zCCA9ugAwIBAgIUMDAwMDEwMDAwMDA1MDUwOTU5NTQwDQYJKoZIhvcNAQELBQAwggGEMSAwHgYDVQQDDBdBVVRPUklEQUQgQ0VSVElGSUNBRE9SQTEuMCwGA1UECgwlU0VSVklDSU8gREUgQURNSU5JU1RSQUNJT04gVFJJQlVUQVJJQTEaMBgGA1UECwwRU0FULUlFUyBBdXRob3JpdHkxKjAoBgkqhkiG9w0BCQEWG2NvbnRhY3RvLnRlY25pY29Ac2F0LmdvYi5teDEmMCQGA1UECQwdQVYuIEhJREFMR08gNzcsIENPTC4gR1VFUlJFUk8xDjAMBgNVBBEMBTA2MzAwMQswCQYDVQQGEwJNWDEZMBcGA1UECAwQQ0lVREFEIERFIE1FWElDTzETMBEGA1UEBwwKQ1VBVUhURU1PQzEVMBMGA1UELRMMU0FUOTcwNzAxTk4zMVwwWgYJKoZIhvcNAQkCE01yZXNwb25zYWJsZTogQURNSU5JU1RSQUNJT04gQ0VOVFJBTCBERSBTRVJWSUNJT1MgVFJJQlVUQVJJT1MgQUwgQ09OVFJJQlVZRU5URTAeFw0yMDA5MTgxNzI0MTBaFw0yNDA5MTgxNzI0MTBaMIHBMSEwHwYDVQQDExhBTEVKQU5EUk8gT1JUSVogR1VFUlJFUk8xITAfBgNVBCkTGEFMRUpBTkRSTyBPUlRJWiBHVUVSUkVSTzEhMB8GA1UEChMYQUxFSkFORFJPIE9SVElaIEdVRVJSRVJPMRYwFAYDVQQtEw1PSUdBODkwNTI4QUw2MRswGQYDVQQFExJPSUdBODkwNTI4SENIUlJMMDUxITAfBgNVBAsTGEFMRUpBTkRSTyBPUlRJWiBHVUVSUkVSTzCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAIM8gykqEkU4MlDY7Kqr3727zyFaSspenpN9y/YSPqaPBPz+8DX9Mi9JFegkKeg435ItxFQMVGE/4J3YZRxAwPZT2aOiFVB1kyWmeNkvSJMlZvTgIubY/909/zFrJ+KMZxa7z+vWQBA1BUY0N5FF+oJYTW3JlkNOFNnp8iuALFdfhUWUKKXOT3nX9+FPXiU9YUS+GhiNOqp/gpq589+JSk/odBiJtFPHVm6NZpjrSpxAldmOhsyicK5BRdKkFeJu85jKNoPu24tPlAqh6MKTwjRYZVerwOekWu3eWK7l0Y6VwXFPOsJ9bVm8z3dkLk4JGDSHEDeRMng7FR3gIgZ84yUCAwEAAaMdMBswDAYDVR0TAQH/BAIwADALBgNVHQ8EBAMCBsAwDQYJKoZIhvcNAQELBQADggIBALXR7aI6f/SwBDwaaHHmCg3Nc0owiMnooRWXzQ12X9ZXf/9lTAMzvRiUqgAcsx8I/dpP9/En5Aiag0iAmjN7X4/DFdWwq/LYnYHQ2mCNX59ED+IpV+QHO6H/HjaZTZVvgyIjZsyLaforOTTne8f2aek843PT2u6sKLedbGbcN6Iwvh9+uyDENJgF0jeXdL6Ek83fEOSMCPOJ/8sh2uR5E5enfCarMwny3+S4KIAYg3DPWBFt88hX1V1cwfXtDXj8y2RedFv6aX7yVrZEPCuzPAPoj2zVkH2IGClvjpraiOy/lIA9xA15IgCp8Dc938FIxAHP4hSQqiIz7pLNXJeXH3B4/rGP42FBd2sP3IZ+YRFehH4KIgZuU8z2XRwiUtXMUhulTkLKqWVFSH6XZyCGe2fOnqJ9bnUZp/QMXDUfQvWyUiNN74vdbv3hcxF9/Un1SWeuEDNKsx7OLfd1WEeQ3pTbN1S3awJS4K+0kaiN7/bHjIfkbE0ynk3LrA70JH8apWAeNkKDwT3niFfN1E+vqk0FBfxB54SyyA/0P6/h4GSgoaOq7fhJXXDGHj43jOZc5DOUd5rrgaQMAhXmwdBpirbMh2qTlI2rl0ETSmmOy84dCF226tskmLVfoX5ogn0lPp0SF1AD3p26VjRxbUuWFTbrnyRXRE4n7ezecVBL6hQD" SubTotal="500.00" Moneda="MXN" Total="540.00" TipoDeComprobante="I" FormaPago="03" MetodoPago="PUE" LugarExpedicion="32410" Exportacion="01" Sello="X295BRrRXNL+FaKxWSc4FQbQ18nGksNHxG2Hqx0hxQYA3IAm/P2GImau9lcoB1u37OmjWQsRgGMqgfo7MYYjQBAwecfNsICPnEz2UHloOk+mcE6MGaMQANKnbGdPhK++VFDKLISYRIhgKo8oj82/lpJMgRY1ZDuHzoHtBD+BYmM1Fgcrjuv2lvqRD2qjhN0ohKoqGJhqy+zGF6yX7fXgSAa3CmXgpc3cu5A1m39KBV47o1V7H9EGlarNaEvjnFNO/L4J2Try+B+Y4CefLpyZsfnWSqZ5oc+knFLB+nwQHcLgxR2ZBsAEatFdXWMXCXB1cVtZkGEa3w1Nwyy758rGhw=="><cfdi:Emisor Nombre="ALEJANDRO ORTIZ GUERRERO" Rfc="OIGA890528AL6" RegimenFiscal="612" /><cfdi:Receptor Nombre="GUILLERMO VILLANUEVA GUTIERREZ" Rfc="VIGG731108D48" DomicilioFiscalReceptor="32320" RegimenFiscalReceptor="612" UsoCFDI="G03" /><cfdi:Conceptos><cfdi:Concepto ClaveUnidad="E48" ClaveProdServ="81111506" NoIdentificacion="N/A" Cantidad="1.00" Descripcion="Renta de servidor (Noviembre 2022)" ValorUnitario="500.00" Importe="500.00" ObjetoImp="02"><cfdi:Impuestos><cfdi:Traslados><cfdi:Traslado Base="500.00" Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.080000" Importe="40.00" /></cfdi:Traslados></cfdi:Impuestos></cfdi:Concepto></cfdi:Conceptos><cfdi:Impuestos TotalImpuestosTrasladados="40.00"><cfdi:Traslados><cfdi:Traslado Base="500" Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.080000" Importe="40.00" /></cfdi:Traslados></cfdi:Impuestos><cfdi:Complemento><tfd:TimbreFiscalDigital Version="1.1" RfcProvCertif="SVT110323827" UUID="F0BEBD03-2D9D-42DE-BD06-034C33F68B40" FechaTimbrado="2022-12-16T08:40:43" SelloCFD="X295BRrRXNL+FaKxWSc4FQbQ18nGksNHxG2Hqx0hxQYA3IAm/P2GImau9lcoB1u37OmjWQsRgGMqgfo7MYYjQBAwecfNsICPnEz2UHloOk+mcE6MGaMQANKnbGdPhK++VFDKLISYRIhgKo8oj82/lpJMgRY1ZDuHzoHtBD+BYmM1Fgcrjuv2lvqRD2qjhN0ohKoqGJhqy+zGF6yX7fXgSAa3CmXgpc3cu5A1m39KBV47o1V7H9EGlarNaEvjnFNO/L4J2Try+B+Y4CefLpyZsfnWSqZ5oc+knFLB+nwQHcLgxR2ZBsAEatFdXWMXCXB1cVtZkGEa3w1Nwyy758rGhw==" NoCertificadoSAT="00001000000413073350" SelloSAT="HbvvzXKQYSOAHhWTcTAZqTdddfmr4Bnn0wkQ9w57ts9KU1r3v9eFuHtqx7aL9AI6Z24hBQVEdbuNxm/sZFGIc19EOsyLXMQSyyUVk2XWXeQ+CAQdAf3b+DTyQyJp8s2VUS/G4piD0GmgqEWam97AYy4WFdzq/efaebEerBUwcfucH8TksM44fFPYg63UraMW0OqhdlyPkBEuNYhJh9HX65AQP+e5fUqdjx1vhNehSWPq8DFIE8QYubWgN8YJaV89Lh7kqUAhEEIc+hbZUK8m5mtMZrX1Ye2Z9NaEUJHia7e0CkLMoM0GrARYGXrUvIS1TSF6c9KhL+WRqIOI7cs+ag==" xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital" xsi:schemaLocation="http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd" /></cfdi:Complemento></cfdi:Comprobante>';

            if($result->OperacionExitosa)
            {
                return [
                    'success' => true,
                    'message' => 'TIMBRADO DEMO',
                    'uuid' => $result->Timbre->UUID,
                    'xml' => $result->XMLResultado,
                    'data' => json_encode($result),
                ];
            }

            return [
                'success' => false,
                'message' => $result->MensajeErrorDetallado,
                'codigo_respuesta' => $result->CodigoRespuesta,
                'mensaje_error' => $result->MensajeError,
                'mensaje_error_detallado' => $result->MensajeErrorDetallado,
                'data' => json_encode($result),
            ];
            
        } catch (\Exception $ex) {
            return response('error', 500);
        }
    }

    public static function TimbrarComplementoDEMO($factura){
        try 
        {
            $result = new stdClass();
            $result->OperacionExitosa = true;
            $result->Timbre = new stdClass();
            $result->Timbre->UUID = '174C6634-C959-4186-8EC2-23F42B7BE268';
            $result->XMLResultado = $factura->xml;

            $result->CodigoRespuesta = 'CodigoRespuesta';
            $result->MensajeError = 'MensajeError';
            $result->MensajeErrorDetallado = 'MensajeErrorDetallado';

            $result->XMLResultado = '<?xml version="1.0" encoding="UTF-8"?><cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd" Version="4.0" Serie="A" Folio="324" Fecha="2023-03-04T11:25:17" NoCertificado="00001000000505095954" Certificado="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" SubTotal="0" Moneda="XXX" Total="0" TipoDeComprobante="P" LugarExpedicion="32410" Exportacion="01" Sello="LX19rngUkk8Qyx6Ubxmz2oOtL0hLcEYS8XNoKL1FGVFjWQQwEuIIpiEYpPdLQw+7DipR7679bk8Oe7c56/p97aW4YFDDcjFOp5KaaT4XQ6OLqHfSokQsuxiy/E+ICTMJUWa2TPjoDz8wsF24atSLxq5LxNN1mH0hrYQeeSRtOTKnqAnN4noF548A36VHALtgffECUmol2UJrUVO/XqpwqULUW7n4lVaB+Aftyoxo7ySfvGW54qNfubrSGYL817dg4wLXG75WufIsgOxFvqUekT0fYDYQ3kkWY9/SivQkKGhGC1R5DClc6DbjKsaJaYLL/WcR9lkLtqOil5woO09DRQ=="><cfdi:Emisor Nombre="ALEJANDRO ORTIZ GUERRERO" Rfc="OIGA890528AL6" RegimenFiscal="612" /><cfdi:Receptor Nombre="REYES DAVID VALENZUELA HERNANDEZ" Rfc="VAHR720106PY5" DomicilioFiscalReceptor="33000" RegimenFiscalReceptor="612" UsoCFDI="CP01" /><cfdi:Conceptos><cfdi:Concepto ClaveUnidad="ACT" ClaveProdServ="84111506" Cantidad="1" Descripcion="Pago" ValorUnitario="0" Importe="0" ObjetoImp="01" /></cfdi:Conceptos><cfdi:Complemento><pago20:Pagos xmlns:pago20="http://www.sat.gob.mx/Pagos20" Version="2.0"><pago20:Totales MontoTotalPagos="702.00" TotalTrasladosBaseIVA8="650.00" TotalTrasladosImpuestoIVA8="52.00" /><pago20:Pago FechaPago="2023-02-28T12:00:00" FormaDePagoP="03" MonedaP="MXN" TipoCambioP="1" Monto="702.00"><pago20:DoctoRelacionado IdDocumento="96DB4B01-519E-4161-A543-374EF0378BF9" Serie="A" Folio="323" MonedaDR="MXN" ObjetoImpDR="02" EquivalenciaDR="1" NumParcialidad="1" ImpSaldoAnt="702.00" ImpPagado="702.00" ImpSaldoInsoluto="0.00"><pago20:ImpuestosDR><pago20:TrasladosDR><pago20:TrasladoDR BaseDR="650.00" ImpuestoDR="002" TipoFactorDR="Tasa" TasaOCuotaDR="0.080000" ImporteDR="52.00" /></pago20:TrasladosDR></pago20:ImpuestosDR></pago20:DoctoRelacionado><pago20:ImpuestosP><pago20:TrasladosP><pago20:TrasladoP BaseP="650.00" ImpuestoP="002" TipoFactorP="Tasa" TasaOCuotaP="0.080000" ImporteP="52.00" /></pago20:TrasladosP></pago20:ImpuestosP></pago20:Pago></pago20:Pagos><tfd:TimbreFiscalDigital Version="1.1" RfcProvCertif="STA0903206B9" UUID="174C6634-C959-4186-8EC2-23F42B7BE268" FechaTimbrado="2023-03-04T11:25:20" SelloCFD="LX19rngUkk8Qyx6Ubxmz2oOtL0hLcEYS8XNoKL1FGVFjWQQwEuIIpiEYpPdLQw+7DipR7679bk8Oe7c56/p97aW4YFDDcjFOp5KaaT4XQ6OLqHfSokQsuxiy/E+ICTMJUWa2TPjoDz8wsF24atSLxq5LxNN1mH0hrYQeeSRtOTKnqAnN4noF548A36VHALtgffECUmol2UJrUVO/XqpwqULUW7n4lVaB+Aftyoxo7ySfvGW54qNfubrSGYL817dg4wLXG75WufIsgOxFvqUekT0fYDYQ3kkWY9/SivQkKGhGC1R5DClc6DbjKsaJaYLL/WcR9lkLtqOil5woO09DRQ==" NoCertificadoSAT="00001000000506204896" SelloSAT="rDvK2uYV/m0L2LTTugiFJM/fcK6/ZfYMAcs5k025oSleqv7E8vIC68F2JhI1V8jfFNqd4WVKCW93tT+Ej4MbM7v0hyeG4TXgpV7RybNmg7T3q8E2W1SIRuQsT5n4CkZ4GAd9gjzconxP3rbztWjpYXXRpXHy6B9zda8VpdSNzcfwuFzEl+UPT99tR+fHDpNPy806jb7yPCriNYiuZDgXqTHLTYL9GhdTZdhgiJVcH6eYxaf8mrZLmNJtniTtR+FSlby6NlNrpHSyfPFNPAPtJYo/ZQjxfwJft8ux74ea3ejBYBWjNaqgQ1k6JzjOvlEqR1k9Ql811atfsfvfofX1CQ==" xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital" xsi:schemaLocation="http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd" /></cfdi:Complemento></cfdi:Comprobante>';

            if($result->OperacionExitosa)
            {
                return [
                    'success' => true,
                    'message' => 'TIMBRADO DEMO',
                    'uuid' => $result->Timbre->UUID,
                    'xml' => $result->XMLResultado,
                    'data' => json_encode($result),
                ];
            }

            return [
                'success' => false,
                'message' => $result->MensajeErrorDetallado,
                'codigo_respuesta' => $result->CodigoRespuesta,
                'mensaje_error' => $result->MensajeError,
                'mensaje_error_detallado' => $result->MensajeErrorDetallado,
                'data' => json_encode($result),
            ];
            
        } catch (\Exception $ex) {
            return response('error', 500);
        }
    }

    public static function getCadenaOriginal($xml){
        $xsl = new DOMDocument();
        error_reporting(E_ERROR);
        $xsl->load('http://www.sat.gob.mx/sitio_internet/cfd/4/cadenaoriginal_4_0/cadenaoriginal_4_0.xslt');
        // $xsl->load(public_path('storage/facturacion/cadenaoriginal_4_0.xslt'));
        
        $XSLT_proc = new XSLTProcessor();
        $XSLT_proc->importStyleSheet($xsl);

        $CadenaOriginal = str_replace(array("\r", "\n"), '', $XSLT_proc->transformToXML($xml) );
        return $CadenaOriginal;
    }

    public static function CancelarFactura(Request $request){
        $factura_id = $request->input('factura_id');
        $motivo = $request->input('motivo');
        $folio_sustitucion = $request->input('folio_sustitucion');

        $factura = Factura::findOrFail($factura_id);
        $res = self::CancelarCFDI($factura, [
            'motivo' => $motivo,
            'folio_sustitucion' => $folio_sustitucion,
        ]);

        if($res['success'] == true){
            $factura->estatus = "CANCELADO";
            $factura->save();
        }

        return $res;

    }

    public static function CancelarCFDI($factura, $data){
        try 
        {
            $cfdi = new TicketFacturaResource($factura);

            $emisor = $factura->emisor;
            $soapclient = new SoapClient('https://www.foliosdigitalespac.com/WSTimbrado33/WSCFDI33.svc?WSDL'); //PRODUCTION
        
            $cfdi_cancelar = [
                'DetalleCFDICancelacion' => [
                    'Motivo' => str_pad($data['motivo'], 2, '0', STR_PAD_LEFT),
                    'RFCReceptor' => $cfdi->entidad_fiscal->rfc,
                    'Total' => $cfdi->total,
                    'UUID' => $cfdi->uuid,
                    'FolioSustitucion' => $data['folio_sustitucion'],
                ]
            ];

            if($cfdi_cancelar['DetalleCFDICancelacion']['Motivo'] === '01'){
                $cfdi_cancelar['DetalleCFDICancelacion']['FolioSustitucion'] = $data['folio_sustitucion'];
            }

            $params = array(
                'usuario' => $emisor->fd_user,
                'password' => $emisor->fd_pass,
                'rFCEmisor'=> $emisor->rfc,
                'listaCFDI' => $cfdi_cancelar,
                'clavePrivada_Base64' => $emisor->pfx,
                'passwordClavePrivada' => $emisor->clave_certificado,
            );

            
            $response = $soapclient->CancelarCFDI($params);
            $result = $response->CancelarCFDIResult;
            

            if($result->OperacionExitosa)
            {
                return [
                    'success' => true,
                    'message' => 'Se ha cancelado factura',
                ];
            }

            $error = "Error al cancelar factura";
            if(property_exists($result,'DetallesCancelacion')){
                $error = $result->DetallesCancelacion->DetalleCancelacion->MensajeResultado;
            }
            ErrorLog::create(['titulo' => 'CancelarFactura', 'error' => $error, 'data' => json_encode($result)]);

            return [
                'success' => false,
                'message' => $error,
                'data' => json_encode($result),
            ];
            
        } catch (\Exception $ex) {
            ErrorLog::create(['titulo' => 'CancelarFactura', 'error' => $ex->getMessage()]);
            return response($ex->getMessage(), 500);
        }
    }

    
}
