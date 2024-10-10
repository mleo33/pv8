<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reporte de Ventas</title>
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
  <h3>Reporte de Ventas</h3>
  <p><b>Fecha:</b> {{$start_date}} al {{$end_date}}</p>
  <p><b>Sucursal:</b> {{ App\Models\Sucursal::find($sucursal_id)->nombre }}</p>
  @if ($user_id)
    <p><b>Vendedor:</b> {{ App\Models\User::find($user_id)->name }}</p>
  @endif
  <br>

  @if ($ventas->count() > 0)
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th align="left">Venta</th>
          <th align="left">Fecha</th>
          <th align="left">Vendedor</th>          
          <th align="left">Cliente</th>
          <th align="right">Monto</th>
        </tr>
      </thead>
      <tbody>
        @php
          $monto = 0;
        @endphp
        @foreach ($ventas as $venta)
          <tr>
              <td>@paddy($venta->id)</td>
              <td>{{ $venta->fecha_format() }}</td>
              <td>{{ $venta->usuario->name }}</td>
              <td>{{ $venta->cliente->nombre ?? 'NO IDENTIFICADO' }}</td> 
              <td align="right">@money($venta->total())</td>
          </tr>
          @php
              $monto += $venta->total();
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
    <h3>No existen ventas.</h3>
  @endif

</body>
</html>