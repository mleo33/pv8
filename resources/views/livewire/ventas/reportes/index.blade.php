@section('title', __('Ver Ventas'))
@extends('adminlte::page')

@section('css')
@endsection

@section('content')

    @include('partials.system.loader')
    @livewire('reportes.ver-ventas')

@endsection