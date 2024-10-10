@section('title', __('Usuarios'))
<div class="pt-4">

    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Catalogo de Usuarios</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-success m-2" data-toggle="modal" data-target="#mdl"><i class="fas fa-plus"></i> Agregar Usuario</button>
          </div>

          <div class="form-group m-3">
            
            <label for="keyWord">Buscar</label>
            <input type="text" wire:model="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
          </div>
          

          <table class="table table-striped projects">
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha de alta</th>
                <th>Nombre</th>
                <th>Sucursal</th>
                <th>Correo</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($usuarios as $elem)
                <tr>
                  <td>{{ $elem->id }}</td>
                  <td>{{ $elem->created_at->diffForHumans() }}</td>
                  <td>{{ $elem->name }}</td>
                  <td>{{ $elem->sucursal->nombre }}</td>
                  <td>{{ $elem->email }}</td>
                  <td>
                    <button class="btn btn-sm btn-warning" wire:click="edit({{ $elem->id }})"><i class="fa fa-edit"></i> Editar</button>
                    <button class="btn btn-sm btn-danger" onclick="destroy('{{ $elem->id }}', 'a {{ $elem->name }}')"><i class="fas fa-trash"></i> Eliminar</button>
                  </td>
              @endforeach
            </tbody>
          </table>
          
        </div>
    </div>

    {{-- @include('livewire.usuarios.modal') --}}
    
</div>





