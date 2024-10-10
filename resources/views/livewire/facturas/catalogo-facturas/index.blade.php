@section('title', __('Reporte de Facturas'))
@extends('adminlte::page')

@section('content')

    @include('partials.system.loader')
    @livewire('facturas.catalogo-facturas')
    @livewire('factura.mdl-cancelar-factura')

@endsection