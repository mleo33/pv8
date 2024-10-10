@section('title', __('Proveedores'))
<div class="pt-4">

    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Catalogo de Proveedores</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">         



          <div class="form-group m-3">
            <label for="keyWord">Buscar</label>
            <input type="text" wire:keydown="resetPage()" wire:model="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
          </div>

          <div class="d-flex justify-content-between">
            <button class="btn btn-xs btn-success m-2" data-toggle="modal" data-target="#mdl"><i class="fas fa-plus"></i> Agregar Proveedor</button>

            <a href="{{route('proveedores.pdf')}}" class="btn btn-xs btn-primary m-2" target="_blank"><i class="far fa-file-pdf"></i> Exportar PDF</a>
          </div>
          
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($proveedores as $proveedor)
                <tr>
                  <td>{{ $proveedor->id_paddy }}</td>
                  <td>{{ $proveedor->nombre }}</td>
                  <td>{{ $proveedor->telefono }}</td>
                  <td>{{ $proveedor->correo }}</td>
                  <td>
                    <a class="btn btn-xs btn-warning" data-toggle="modal" data-target="#mdl" class="dropdown-item" wire:click="edit({{ $proveedor->id }})"><i class="fa fa-edit"></i> Editar</a>
                    <button class="btn btn-xs btn-danger" onclick="borrar('{{ $proveedor->id }}', '{{ $proveedor->nombre }}')"><i class="fas fa-trash"></i> Eliminar</button>
                  </td>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>
    {{ $proveedores->links() }}

    @include('livewire.proveedores.modal')
    
</div>





