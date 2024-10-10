<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reporte de articulos vendidos</title>
  <style>
    h3{
      margin-top: 5px;
      margin-bottom: 5px;
    }
    P{
      margin: 5px;
    }
    tbody{
      font-size: 8px;
    }
    tr{
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <h4>Reporte de articulos vendidos</h4>
  <p><b>Fecha:</b> {{$start_date}} al {{$end_date}}</p>
  <p><b>Sucursal:</b> {{ App\Models\Sucursal::find($sucursal_id)->nombre }}</p>
  @if ($user_id)
    <p><b>Vendedor:</b> {{ App\Models\User::find($user_id)->name }}</p>
  @endif
  <br>

  @if ($articulos->count() > 0)
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th align="left">#</th>
          <th align="left">Venta</th>
          <th align="left">Fecha</th>
          <th align="left">Vendedor</th>          
          <th align="left">Descripción</th>
          <th align="left">Cantidad</th>
          <th align="left">Precio</th>
          <th align="right">Importe</th>
        </tr>
      </thead>
      <tbody>
        @php
          $monto = 0;
        @endphp
        @foreach ($articulos as $articulo)
          <tr>
              <td>{{ $loop->iteration }}</td>
              <td>@paddy($articulo->venta->id)</td>
              <td>{{ $articulo->venta->fecha_format() }}</td>
              <td>{{ $articulo->venta->usuario->name }}</td>
              <td>{{ $articulo->descripcion }}</td>
              <td>{{ $articulo->cantidad }}</td>
              <td align="right">@money($articulo->precio)</td>
              <td align="right">@money($articulo->importe())</td>
          </tr>
          @php
              $monto += $articulo->importe();
          @endphp
        @endforeach
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td align="right"><b>@money($monto)<b></td>
        </tr>
      </tbody>
      
    </table>      
  @else
    <h3>No existen articulos.</h3>
  @endif

</body>
</html>