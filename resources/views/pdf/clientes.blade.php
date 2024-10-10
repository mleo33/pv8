@extends('pdf.layout.template')
@section('title', 'Catalogo de Clientes')
@section('file-title', 'Reporte de Clientes')

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
        @foreach ($clientes as $cliente)
            <tr>
                <td align="center">{{ $cliente->id }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($cliente->created_at)->format('d-m-y')}}</td>
                <td align="left">{{ $cliente->nombre }}</td> 
                <td align="left">{{ $cliente->direccion }}</td> 
                <td align="left">{{ $cliente->telefono }}</td>
                <td align="left">{{ $cliente->correo }}</td>
            </tr>
        @endforeach
      </tbody>
      
    </table>
  </section>

@endsection
