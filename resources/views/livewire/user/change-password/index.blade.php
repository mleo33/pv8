@section('title', __('Cambiar Contraseña'))
@extends('layouts.public')


@section('content')

    @include('shared.system.loader')
    @livewire('user.change-password')

@endsection