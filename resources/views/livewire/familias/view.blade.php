@section('title', __('Familias'))
<div class="p-3">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Catalogo de Familias</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
            <button class="btn btn-sm btn-success m-2" data-toggle="modal" data-target="#mdl"><i class="fas fa-plus"></i> Agregar Familia</button>
            <div class="form-group m-3">
              <label for="keyWord">Buscar</label>
              <input type="text" wire:model="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
            </div>
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Abreviación</th>
                <th>Equipos</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($familias as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->nombre }}</td>
                  <td>{{ $item->abreviacion }}</td>
                  <td>
                    @if ($item->equipos->count() > 0)
                      <button class="btn btn-sm btn-primary"><i class="fa fa-caravan mr-2"></i> {{$item->equipos->count()}}</button>
                    @else
                      N/A
                    @endif
                  </td>
                  <td>
                    <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#mdl" class="dropdown-item" wire:click="edit({{ $item->id }})"><i class="fa fa-edit"></i> Editar</a>
                    <button class="btn btn-sm btn-danger" onclick="borrar('{{ $item->id }}', '{{ $item->nombre }}')"><i class="fas fa-trash"></i> Eliminar</button>
                  </td>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>
    {{ $familias->links() }}

    @include('livewire.familias.modal')
</div>




<script>
  function borrar(id, name){
    new Swal({
      title: 'Eliminar ' + name,
      text: '¿Desea eliminar familia: ' + name + '?',
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
          text: 'Se ha eliminado familia: ' + name,
          icon: 'success',
          showConfirmButton: false,
          timer: 1700
        });
      }
    });
  }
</script>