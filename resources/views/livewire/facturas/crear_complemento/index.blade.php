@extends('adminlte::page')

@section('content')

  @include('partials.system.loader')
  @livewire('facturas.crear-complemento', ['factura' => $factura])
  @livewire('factura.mdl-cancelar-factura')
  
@endsection