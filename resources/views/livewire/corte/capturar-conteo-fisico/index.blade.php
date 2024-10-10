@extends('adminlte::page')
@section('title', __('Capturar Fondo'))

@section('content')

    @include('partials.system.loader')
    @livewire('corte.capturar-conteo-fisico')

@endsection

