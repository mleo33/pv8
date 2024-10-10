<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reporte de facturas</title>
  <style>
    h3{
      margin-top: 5px;
      margin-bottom: 5px;
    }
    P{
      margin: 5px;
    }
    tbody{
      font-size: 12px;
    }
    tr{
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <h3>Reporte de Facturas</h3>
  <p><b>Fecha:</b> {{$start_date}} al {{$end_date}}</p>
  <p><b>Sucursal:</b> {{ App\Models\Sucursal::find($sucursal_id)->nombre }}</p>
  @if ($user_id)
    <p><b>Vendedor:</b> {{ App\Models\User::find($user_id)->name }}</p>
  @endif
  <br>

  @if ($facturas->count() > 0)
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th align="left">Venta</th>
          <th align="left">Fecha</th>
          <th align="left">Vendedor</th>          
          <th align="left">Cliente</th>
          <th align="left">Estatus</th>
          <th align="left">Forma de Pago</th>
          <th align="right">Monto</th>
        </tr>
      </thead>
      <tbody>
        @php
          $monto = 0;
        @endphp
        @foreach ($facturas as $factura)
          <tr>
              <td>@paddy($factura->id)</td>
              <td>{{ $factura->fecha_format() }}</td>
              <td>{{ $factura->usuario->name }}</td>
              <td>{{ $factura->entidad_fiscal->nombre ?? 'NO IDENTIFICADO' }}</td>
              <td>{{ $factura->forma_pago }}</td>
              <td align="right">@money($factura->total)</td>
          </tr>
          @php
              $monto += $factura->total;
          @endphp
        @endforeach
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td> 
          <td align="right"><b>@money($monto)<b></td>
        </tr>
      </tbody>
      
    </table>      
  @else
    <h3>No existen facturas.</h3>
  @endif

</body>
</html>