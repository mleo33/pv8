@section('title')
    Renta #@paddy($renta->id)
@endsection

@extends('adminlte::page')

@section('css')
@endsection

@section('content')

    @include('partials.system.loader')
    @livewire('admin.admin-renta', ['renta' => $renta])

@endsection

@section('js')
    <script>
        $('body').addClass('sidebar-collapse');
    </script>
@endsection