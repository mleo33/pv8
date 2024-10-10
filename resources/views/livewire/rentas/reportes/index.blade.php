@section('title', __('Ver Rentas'))
@extends('adminlte::page')

@section('css')
@endsection

@section('content')

    @include('partials.system.loader')
    @livewire('reportes.ver-rentas')

@endsection
