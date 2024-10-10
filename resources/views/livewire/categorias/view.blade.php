@section('title', __('Categorias'))
<div class="p-4">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Catalogo de Categorias</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
            <button class="btn btn-sm btn-success m-2" data-toggle="modal" data-target="#mdl"><i class="fas fa-plus"></i> Agregar Categoria</button>
            <div class="form-group m-3">

              <label for="keyWord">Buscar</label>
              <input type="text" wire:model="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">

            </div>
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($categorias as $row)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $row->nombre }}</td>
                  <td>
                    <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#mdl" class="dropdown-item" wire:click="edit({{ $row->id }})"><i class="fa fa-edit"></i> Editar</a>
                    <button class="btn btn-sm btn-danger" onclick="borrar('{{ $row->id }}', '{{ $row->nombre }}')"><i class="fas fa-trash"></i> Eliminar</button>
                  </td>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>
    {{ $categorias->links() }}

    @include('livewire.categorias.modal')

    
</div>


<script>
  function borrar(id, name){
    new Swal({
      title: 'Eliminar ' + name,
      text: '¿Desea eliminar categoria: ' + name + '?',
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
          text: 'Se ha eliminado categoria: ' + name,
          icon: 'success',
          showConfirmButton: false,
          timer: 1700
        });
      }
    });
  }

  
</script>


