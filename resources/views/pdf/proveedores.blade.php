@extends('pdf.layout.template')
@section('title', 'Catalogo de Proveedores')
@section('file-title', 'Reporte de Proveedores')

@section('content') 

  <section>
            
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
      <thead>
        <tr>
          <th width="5%">ID</th>
          <th width="10%">Registro</th>
          <th width="15%">Nombre</th>          
          <th>Dirección</th>          
          <th width="12%">Teléfono</th>
          <th width="12%">Correo</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($proveedores as $proveedor)
            <tr>
                <td align="center">{{ $proveedor->id }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($proveedor->created_at)->format('d-m-y')}}</td>
                <td align="left">{{ $proveedor->nombre }}</td> 
                <td align="left">{{ $proveedor->direccion }}</td> 
                <td align="left">{{ $proveedor->telefono }}</td>
                <td align="left">{{ $proveedor->correo }}</td>
            </tr>
        @endforeach
      </tbody>
      
    </table>
  </section>

@endsection
