<?php

namespace App\Http\Resources\TicketFactura;

use App\Classes\FacturacionConstants;
use App\Http\Resources\TicketFactura\TicketFacturaConceptosCollection;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Luecano\NumeroALetras\NumeroALetras;
use PhpParser\ErrorHandler\Collecting;

class TicketFacturaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $regimenes = FacturacionConstants::REGIMENES_FISCALES;
        $tipos_comprobante = FacturacionConstants::TIPOS_COMPROBRANTE;
        $metodos_pago = FacturacionConstants::METODOS_PAGO;
        $formas_pago = FacturacionConstants::FORMAS_PAGO;
        $usos_cfdi = FacturacionConstants::USO_CFDI;
        
        $NoFactura = $this['Serie'] . '-' . $this['Folio'];
        $Moneda = $this['Moneda'];
        $FormaPago = $this['FormaPago'];
        $TipoDeComprobante = $this['TipoDeComprobante'];
        $MetodoPago = $this['MetodoPago'];
      
        $emisor = $this->children('cfdi', true)->Emisor[0];
        $receptor = $this->children('cfdi', true)->Receptor[0];
        $conceptos = $this->children('cfdi', true)->Conceptos[0];
      
      
        $NoCertificadoEmisor = $this['NoCertificado'];
        $NombreEmisor = $emisor->attributes()->Nombre;
        $RfcEmisor = $emisor->attributes()->Rfc;
        $RegimenFiscal = $emisor->attributes()->RegimenFiscal;
        $LugarExpedicion = $this['LugarExpedicion'];
      
        $ImpuestosTraslados = $this->children('cfdi', true)->Impuestos[0]->children('cfdi', true)->Traslados[0];
        $IVA = 0;
        $TasaOCuota = 0;
        foreach ($ImpuestosTraslados as $impuesto) {
          if($impuesto->attributes()->Impuesto == '002'){
            $IVA += floatval($impuesto->attributes()->Importe);
            $TasaOCuota = floatval($impuesto->attributes()->TasaOCuota);
          }
        }
        
        $SubTotal = $this['SubTotal'];
        $Total = $this['Total'];
      
      
        $NombreReceptor = $receptor->attributes()->Nombre;
        $RfcReceptor = $receptor->attributes()->Rfc;
        $DomicilioFiscalReceptor = $receptor->attributes()->DomicilioFiscalReceptor;
        $RegimenFiscalReceptor = $receptor->attributes()->RegimenFiscalReceptor;
        $UsoCFDI = $receptor->attributes()->UsoCFDI;
        
        $FechaEmision = $this['Fecha'];
        $Version = $this->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->Version;
        $UUID = $this->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->UUID;
        $FechaTimbrado = $this->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->FechaTimbrado;
        $SelloCFD = $this->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->SelloCFD;
        $NoCertificadoSAT = $this->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->NoCertificadoSAT;
        $SelloSAT = $this->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->SelloSAT;

        $CadenaOriginal = "||" . $Version 
              ."|". $UUID
              ."|". $FechaTimbrado
              ."|". $SelloSAT
              ."|". $NoCertificadoSAT
              ."||";
      
        $totalExploded = explode(".", $Total);
        $QRString = 'https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx';
        $QRString .= "?id=" . $UUID;
        $QRString .= '&re=' . $RfcEmisor;
        $QRString .= "&rr=" . $RfcReceptor;
        $QRString .= "&tt=" . str_pad($totalExploded[0], 10, '0', STR_PAD_LEFT); // TOTAL ENTERO
        $QRString .= "." . str_pad($totalExploded[1], 6, '0'); // DECIMALES
        $QRString .= "&fe=" . substr($SelloCFD, -8);

        $concepts = [];
        foreach($conceptos as $concepto){
            array_push($concepts, [
                "ClaveProdServ" => $concepto->attributes()->ClaveProdServ,
                "Descripcion" => $concepto->attributes()->Descripcion,
                "ClaveUnidad" => $concepto->attributes()->ClaveUnidad,
                "Cantidad" => $concepto->attributes()->Cantidad,
                "ValorUnitario" => $concepto->attributes()->ValorUnitario,
                "Importe" => $concepto->attributes()->Importe,
            ]);
        }

        $ob = new NumeroALetras();
        $ob->apocope = true;
        $ImporteLetra = $ob->toInvoice(floatval($Total), 2, 'MXN');
        
        return [
            'NoFactura' => $this['Serie'] . '-' . $this['Folio'],
            'UUID' => strval($UUID),
            'NoCertificadoSAT' => strval($NoCertificadoSAT),
            'NoCertificadoEmisor' => strval($NoCertificadoEmisor),
            'FechaTimbrado' => strval($FechaTimbrado),
            'FechaEmision' => strval($FechaEmision),

            'NombreEmisor' => strval($NombreEmisor),
            'RfcEmisor' => strval($RfcEmisor),
            'RegimenFiscal' => "{$RegimenFiscal} - {$regimenes[intval($RegimenFiscal)]}",
            'LugarExpedicion' => strval($LugarExpedicion),

            'NombreReceptor' => strval($NombreReceptor),
            'RfcReceptor' => strval($RfcReceptor),
            'DomicilioFiscalReceptor' => strval($DomicilioFiscalReceptor),
            'RegimenFiscalReceptor' => "{$RegimenFiscalReceptor} - {$regimenes[intval($RegimenFiscalReceptor)]}",
            'UsoCFDI' => "{$UsoCFDI} - {$usos_cfdi[utf8_encode($UsoCFDI)]}",

            'NoFactura' => strval($NoFactura),
            'Moneda' => strval($Moneda),
            'FormaPago' => "{$FormaPago} - {$formas_pago[intval($FormaPago)]}",
            'TipoDeComprobante' => "{$TipoDeComprobante} - {$tipos_comprobante[utf8_encode($TipoDeComprobante)]}",
            'MetodoPago' => "{$MetodoPago} - {$metodos_pago[utf8_encode($MetodoPago)]}",

            'SubTotal' => strval($SubTotal),
            'IVA' => $IVA,
            'Total' => strval($Total),
            'TasaOCuota' => $TasaOCuota,
            'ImporteLetra' => $ImporteLetra,

            'conceptos' => TicketFacturaConceptoResource::collection($concepts),

            'SelloCFD' => strval($SelloCFD),
            'SelloSAT' => strval($SelloSAT),
            'CadenaOriginal' => strval($CadenaOriginal),
            'QRString' => $QRString,
        ];
    }
}
