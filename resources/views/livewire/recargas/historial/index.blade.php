@section('title', __('Recargas'))
@extends('adminlte::page')

@section('content')

    @include('partials.system.loader')
    @livewire('recargas.historial')

@endsection