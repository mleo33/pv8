@extends('adminlte::page')

@section('content')

    @include('partials.system.loader')
    @livewire('pedido.catalogo-pedidos')
    @livewire('pedido.common.mdl-recibir-pedido')
    @livewire('pedido.common.mdl-enviar-pedido-correo')

@endsection