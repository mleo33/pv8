@section('title', __('Capturar Fondo'))

@extends('layouts.public')



@section('content')

    @include('partials.system.loader')
    @livewire('corte.capturar-fondo')

@endsection

@section('js')
<script>
    const myInput = document.getElementById("iptMonto");
    const myForm = document.getElementById("form");

    myInput.addEventListener("keydown", function (event) {
        if (event.key === "Enter" || event.keyCode === 13) {
            event.preventDefault();
            myForm.submit();
        }
    });
</script>
@endsection
