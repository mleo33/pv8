@extends('adminlte::page')



@section('content')

  @include('partials.system.loader')
  @livewire('ventas.ver-venta', ['venta' => $venta])

@endsection
