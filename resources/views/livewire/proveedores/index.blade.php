@extends('adminlte::page')

@section('content')

  @include('partials.system.loader')
  @livewire('proveedores')

    
@endsection

@section('js')
    <script>
        function borrar(id, name){
          new Swal({
            title: 'Eliminar ' + name,
            text: '¿Desea eliminar a ' + name + '?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Eliminar',
            confirmButtonColor: '#d33',
          }).then(function(result){
            if(result.value){
              window.livewire.emit('deleteRow', id);
              Swal.fire({
                title: 'Eliminado',
                text: 'Se ha eliminado a ' + name,
                icon: 'success',
                showConfirmButton: false,
                timer: 1700
              });
            }
          });
        }

        function test(){
            alert(2);
        }
      </script>
@endsection