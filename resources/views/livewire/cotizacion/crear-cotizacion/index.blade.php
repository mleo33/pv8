@extends('adminlte::page')

@section('content')

    @include('partials.system.loader')
    @livewire('cotizacion.crear-cotizacion')

@endsection

@section('js')
<script>
function changeQty(id, descripcion, cantidad) {
    new Swal({
      title: 'Modifica la cantidad de ' + descripcion,
      input: 'number',
      inputValue: cantidad,
      showCancelButton: true,
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Modificar',
      confirmButtonColor: '#007BFF',
    }).then(function(result) {
      if (result.isConfirmed) {
        window.livewire.emit('addQty', id, (result.value - cantidad));          
      }
    });
}
</script>
@endsection