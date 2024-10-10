@section('title', __('Reporte de Facturas'))
@extends('adminlte::page')

@section('css')
@endsection

@section('content')

    @include('partials.system.loader')
    @livewire('reportes.reporte-facturas')

@endsection