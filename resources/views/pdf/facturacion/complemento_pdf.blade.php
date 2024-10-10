<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{$factura->uuid}}</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td style="font-size: 15px;" align="center">
          <h2 style="margin: 2px;">Don Martin Remolques y Maquinaria</h2>
        </td>
    </tr>
  </table>
  <br>

{{-- /////////////////////////////////// --}}
@php
  $NoFactura = $xml['Serie'] . $xml['Folio'];
  $Moneda = $xml['Moneda'];
  $FormaPago = $xml['FormaPago'];
  $FechaEmision = $xml['Fecha'];
  $TipoDeComprobante = $xml['TipoDeComprobante'];
  $NoCertificadoEmisor = $xml['NoCertificado'];
  $LugarExpedicion = $xml['LugarExpedicion'];
  $SubTotal = $xml['SubTotal'];
  $Total = $xml['Total'];


  $emisor = $xml->children('cfdi', true)->Emisor[0];
  $receptor = $xml->children('cfdi', true)->Receptor[0];
  $conceptos = $xml->children('cfdi', true)->Conceptos[0];


  $NombreEmisor = $emisor->attributes()->Nombre;
  $RfcEmisor = $emisor->attributes()->Rfc;
  $RegimenFiscal = $emisor->attributes()->RegimenFiscal;

  $ImpuestosTraslados = $xml->children('cfdi', true)->Impuestos[0]->children('cfdi', true)->Traslados[0];
  $IVA = 0;
  $TasaOCuota = 0;
  foreach ($ImpuestosTraslados as $impuesto) {
    if($impuesto->attributes()->Impuesto == '002'){
      $IVA += floatval($impuesto->attributes()->Importe);
      $TasaOCuota = floatval($impuesto->attributes()->TasaOCuota);
    }
  }
  



  $NombreReceptor = $receptor->attributes()->Nombre;
  $RfcReceptor = $receptor->attributes()->Rfc;
  $DomicilioFiscalReceptor = $receptor->attributes()->DomicilioFiscalReceptor;
  $RegimenFiscalReceptor = $receptor->attributes()->RegimenFiscalReceptor;
  $UsoCFDI = $receptor->attributes()->UsoCFDI;
  
  // $Version = $xml->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->Version;
  // $UUID = $xml->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->UUID;
  // $FechaTimbrado = $xml->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->FechaTimbrado;
  // $SelloCFD = $xml->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->SelloCFD;
  // $NoCertificadoSAT = $xml->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->NoCertificadoSAT;
  // $SelloSAT = $xml->children('cfdi', true)->Complemento[0]->children('tfd',true)->TimbreFiscalDigital->attributes()->SelloSAT;

  $Version = 'Version';
  $UUID = 'UUID';
  $FechaTimbrado = 'FechaTimbrado';
  $SelloCFD = 'SelloCFD';
  $NoCertificadoSAT = 'NoCertificadoSAT';
  $SelloSAT = "SELLO";

  $CadenaOriginal = "||" . $Version 
        ."|". $UUID
        ."|". $FechaTimbrado
        ."|". $SelloSAT
        ."|". $NoCertificadoSAT
        ."||";

  $totalExploded = explode(".", $Total);
  $QRText = '?re=' . $RfcEmisor;
  $QRText .= "&rr=" . $RfcReceptor;
  $QRText .= "&tt=" . str_pad($totalExploded[0], 10, '0', STR_PAD_LEFT); // TOTAL ENTERO
  $QRText .= "." . str_pad($totalExploded[1], 6, '0'); // DECIMALES
  $QRText .= "&id=" . $UUID;

  // $QR = new \SimpleSoftwareIO\QrCode\Facades\QrCode();
@endphp
{{-- /////////////////////////////////// --}}
  
  <table width="100%">
    <tr>
      <td style="vertical-align: top" width="25%">
        <table style="font-size: 10px; border: 1px solid; margin: 0px;" align="right" width="100%">
          <tr>
            <td align="center"><b>FOLIO FISCAL [UUID]:</b><br><small>{{$UUID}}</small></td>
          </tr>
          <tr>
            <td align="center"><b>NO. DE SERIE DEL CERTIFICADO DEL SAT:</b><br><small>{{$NoCertificadoSAT}}</small></td>
          </tr>
          <tr>
            <td align="center"><b>NO. DE SERIE DEL CERTIFICADO DEL EMISOR:</b><br><small>{{$NoCertificadoEmisor}}</small></td>
          </tr>
          <tr>
            <td align="center"><b>FECHA Y HORA DE CERTIFICACIÓN:</b><br><small>{{$FechaTimbrado}}</small></td>
          </tr>
          <tr>
            <td align="center"><b>FECHA Y HORA DE EMISIÓN DE CFDI:</b><br><small>{{$FechaEmision}}</small></td>
          </tr>
        </table>
      </td>
      <td style="vertical-align: top" align="center">
        <h3 style="margin: 2px;">EMISOR</h3>
        <p style="margin: 2px;">{{\Str::upper($NombreEmisor)}}</p>
        <p style="margin: 2px;">RFC: {{$RfcEmisor}}</p>
        <p style="margin: 2px;">Régimen Fiscal: {{$RegimenFiscal}}</p>
        <p style="margin: 2px;">Lugar de Expedición: {{$LugarExpedicion}}</p>
      </td>
      <td style="vertical-align: top" align="center">
        <h3 style="margin: 2px;">RECEPTOR</h3>
        <p style="margin: 2px;">{{\Str::upper($NombreReceptor)}}</p>
        <p style="margin: 2px;">RFC: {{$RfcReceptor}}</p>
        <p style="margin: 2px;">Régimen Fiscal: {{$RegimenFiscalReceptor}}</p>
        <p style="margin: 2px;">Domicilio Fiscal: {{$DomicilioFiscalReceptor}}</p>
      </td>
    </tr>
  </table>

  <table width="100%">
    <tr align="center">
      <td width="25%"></td>
      <td>
        <table width="100%">
          <tr align="center">
            <td><b>NO. FACTURA: {{$NoFactura}}</b></td>
            <td><b>TIPO COMPROBANTE: {{$TipoDeComprobante}}</b></td>
            <td><b>MONEDA: {{$Moneda}}</b></td>
            <td><b>FORMA PAGO: {{$FormaPago}}</b></td>
            <td><b>USO CFDI: {{$UsoCFDI}}</b></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <br/>

  <table style="border: 2px solid; border-color: #ffee2d;" width="100%">
    <thead style="background-color: #ffee2d;">
      <tr>
        <th>CANT</th>
        <th>UNIDAD</th>
        <th>IDENTIFICADOR</th>
        <th>DESCRIPCIÓN</th>
        <th>CLAVE PROD</th>
        <th>PRECIO</th>
        <th>IMPORTE</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($conceptos as $concepto)
        <tr>
            <td align="center">{{$concepto->attributes()->Cantidad}}</td>
            <td align="center">{{$concepto->attributes()->ClaveUnidad}}</td>
            <td align="center">{{$concepto->attributes()->NoIdentificacion}}</td>
            <td>{{$concepto->attributes()->Descripcion}}</td>
            <td align="center">{{$concepto->attributes()->ClaveProdServ}}</td>
            <td align="right">@money(floatval($concepto->attributes()->ValorUnitario))</td>
            <td align="right">@money(floatval($concepto->attributes()->Importe))</td>
        </tr>
      @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td></td>
            <td></td>
            <td align="right">SUBTOTAL</td>
            <td align="right">@money(floatval($SubTotal))</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td></td>
            <td></td>
            <td align="right">IVA {{ number_format((floatval($TasaOCuota) * 100),2) }}%</td>
            <td align="right">@money(floatval($IVA))</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td></td>
            <td></td>
            <td align="right">Total</td>
            <td align="right" style="background-color: #ffee2d">@money(floatval($Total))</td>
        </tr>
    </tfoot>
  </table>
  @php
      $ob = new Luecano\NumeroALetras\NumeroALetras();
      $ob->apocope = true;
      $ImporteLetra = $ob->toInvoice(floatval($Total), 2, 'MXN');
      
  @endphp
  <p style="font-size: 10px; margin-top: 0px;">IMPORTE CON LETRA: {{$ImporteLetra}}</p>

  <br>
  <table width="100%">
    <tr>
      <td width="160px">
        {{-- <div style="margin:0px; width: 150px; height: 150px; background-color: #ffee2d"></div> --}}
        {{-- {!! QrCode::size(150)->generate($QRText); !!} --}}
        @php
            $valor = QrCode::size(150)->generate($QRText);
        @endphp
        <img src="data:image/svg+xml;base64,{{ base64_encode($valor) }}">
      </td>
      <td style="vertical-align: top;" align="left">
        <table style="font-size: 8px; margin: 0px;">
          <tr>
            <td><b>SELLO DIGITAL DEL CFDI:</b></td>
          </tr>
          <tr style="overflow-wrap: anywhere">
            <td>{{$SelloCFD}}</td>
          </tr>
          <tr>
            <td><b>SELLO DIGITAL DEL SAT:</b></td>
          </tr>
          <tr style="overflow-wrap: anywhere">
            <td>{{$SelloSAT}}</td>
          </tr>
          <tr>
            <td><b>CADENA ORIGINAL DEL COMPLEMENTO DE CERTIFICACIÓN DIGITAL DEL SAT:</b></td>
          </tr>
          <tr style="overflow-wrap: anywhere">
            <td>{{$CadenaOriginal}}</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

</body>
</html>