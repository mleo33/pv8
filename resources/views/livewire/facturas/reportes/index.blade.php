@section('title', __('Ver Facturas'))
@extends('adminlte::page')

@section('css')
@endsection

@section('content')

    @include('partials.system.loader')
    @livewire('reportes.ver-facturas')

@endsection