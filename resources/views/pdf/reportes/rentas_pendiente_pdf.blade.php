<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reporte de Rentas</title>
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
  <h3>Reporte de Rentas</h3>
  <p><b>Fecha:</b> {{$start_date}} al {{$end_date}}</p>
  <p><b>Sucursal:</b> {{ App\Models\Sucursal::find($sucursal_id)->nombre }}</p>
  @if ($user_id)
    <p><b>Vendedor:</b> {{ App\Models\User::find($user_id)->name }}</p>
  @endif
  <br>

  @if ($rentas->count() > 0)
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th align="left"># Renta</th>
          <th align="left">Fecha</th>
          <th align="left">Vendedor</th>          
          <th align="left">Cliente</th>
          <th align="right">Monto</th>
          <th align="right">Saldo Pendiente</th>
        </tr>
      </thead>
      <tbody>
        @php
          $monto = 0;
        @endphp
        @foreach ($rentas as $renta)
          <tr>
              <td>@paddy($renta->id)</td>
              <td>{{ $renta->fecha_format() }}</td>
              <td>{{ $renta->usuario->name }}</td>
              <td>{{ $renta->cliente->nombre ?? 'NO IDENTIFICADO' }}</td> 
              <td align="right">@money($renta->total())</td>
              <td align="right">@money($renta->saldo_pendiente())</td>
          </tr>
          @php
              $monto += $renta->total();
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
    <h3>No existen rentas.</h3>
  @endif

</body>
</html>