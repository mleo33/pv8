@section('title', __('Ingresos'))
@extends('adminlte::page')

@section('css')
@endsection

@section('content')

    @include('partials.system.loader')
    @livewire('ingresos')

@endsection