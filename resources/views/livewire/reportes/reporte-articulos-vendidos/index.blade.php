@section('title', __('Reporte de Articulos Vendidos'))
@extends('adminlte::page')

@section('css')
@endsection

@section('content')

    @include('partials.system.loader')
    @livewire('reportes.reporte-articulos-vendidos')

@endsection
