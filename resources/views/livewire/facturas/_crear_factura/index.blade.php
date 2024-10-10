@extends('adminlte::page')

@section('content')

  @include('partials.system.loader')
  @livewire('facturas.crear-factura')
  @livewire('cliente.common.mdl-select-cliente')
  @livewire('producto.common.mdl-select-producto')

@endsection