@section('title', __('Reporte de Rentas Pendientes'))
@extends('adminlte::page')

@section('css')
@endsection

@section('content')

    @include('partials.system.loader')
    @livewire('reportes.reporte-rentas-pendientes')

@endsection