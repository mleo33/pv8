@extends('adminlte::page')

@section('content')

    @include('partials.system.loader')
    @livewire('cotizacion.catalogo-cotizaciones')
    @livewire('cotizacion.common.mdl-enviar-cotizacion-correo')

@endsection