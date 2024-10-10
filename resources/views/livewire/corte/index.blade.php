@section('title', __('Corte de Caja'))
@extends('adminlte::page')

@section('css')
@endsection

@section('content')

    @include('partials.system.loader')
    @livewire('corte')

@endsection
