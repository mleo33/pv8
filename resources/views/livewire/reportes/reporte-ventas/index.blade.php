@section('title', __('Reporte de Ventas'))
@extends('adminlte::page')

@section('css')
@endsection

@section('content')

    @include('partials.system.loader')
    @livewire('reportes.reporte-ventas')

@endsection