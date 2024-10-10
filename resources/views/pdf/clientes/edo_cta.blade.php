<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{$cliente->nombre}}</title>
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
  <h3>Estado de Cuenta</h3>
  <p>Fecha: {{date("Y/m/d h:i A")}}</p>
  <p>Cliente: [@paddy($cliente->id)] {{$cliente->nombre}}</p>
  <p>Dirección: {{$cliente->direccion}}</p>
  <p>Linea de Crédito: @money($cliente->limite_credito)</p>
  <p>
    Crédito Disponible: @money($cliente->credito_disponible())
    @if ($cliente->rentas_activas->count() > 0)
        , Contratos activos: {{$cliente->rentas_activas->count()}}
    @endif
  </p>
  <br>

  @if ($cliente->rentas_activas->count() > 0)
    <h3>Contratos activos</h3>
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th align="left">Renta</th>
          <th align="left">Fecha</th>
          <th align="left">Vendedor</th>          
          <th align="right">Monto</th>          
          <th align="right">Pagado</th>
          <th align="right">Saldo Pendiente</th>
        </tr>
      </thead>
      <tbody>
        @php
          $monto = 0;
          $pagado = 0;
          $pendiente = 0;
        @endphp
        @foreach ($cliente->rentas_activas as $renta)
            <tr>
                <td>@paddy($renta->id)</td>
                <td>{{ $renta->fecha_format() }}</td>
                <td>{{ $renta->usuario->name }}</td> 
                <td align="right">@money($renta->total())</td> 
                <td align="right">@money($renta->ingresos->sum('monto'))</td>
                <td align="right">@money($renta->saldo_pendiente())</td>
            </tr>
        @php
          $monto += $renta->total();
          $pagado += $renta->ingresos->sum('monto');
          $pendiente += $renta->saldo_pendiente();
        @endphp
        @endforeach
        <tr>
          <td></td>
          <td></td>
          <td></td> 
          <td align="right"><b>@money($monto)<b></td> 
          <td align="right"><b>@money($pagado)<b></td>
          <td align="right"><b>@money($pendiente)<b></td>
        </tr>
      </tbody>
      
    </table>      
  @else
    <h3>No existen contratos pendientes.</h3>
  @endif

</body>
</html>