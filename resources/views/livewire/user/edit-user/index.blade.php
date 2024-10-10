@extends('adminlte::page')

@section('content')
    @include('shared.system.loader')     
    @livewire('user.edit-user', ['user' => $user ])
@endsection