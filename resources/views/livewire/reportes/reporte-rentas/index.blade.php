@section('title', __('Reporte de Rentas'))
@extends('adminlte::page')

@section('css')
@endsection

@section('content')

    @include('partials.system.loader')
    @livewire('reportes.reporte-rentas')

@endsection