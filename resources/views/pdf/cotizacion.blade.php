@extends('pdf.layout.template')
@section('title', 'Cotizacion')
@section('file-title', 'Cotizacion')

@section('content') 

<table width="100%">
  <thead>
    <tr>
      <th>#</th>
      <th>Código</th>
      <th>Descripción</th>          
      <th>Cantidad</th>          
      <th>Precio</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($cotizacion->registros as $elem)
        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td align="center">{{ $elem->codigo }}</td> 
            <td align="left">{{ $elem->descripcion }}</td> 
            <td align="center">{{ $elem->unidades }}</td> 
            <td align="right">@money($elem->precio)</td>
            <td align="right">@money($elem->importe())</td>
        </tr>
    @endforeach
  </tbody>
  
</table>

@endsection
