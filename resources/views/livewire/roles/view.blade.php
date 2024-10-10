@section('title', __('Roles de Usuarios'))
<div class="pt-4">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Roles de Usuarios</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
            <button class="btn btn-sm btn-success m-2" data-toggle="modal" data-target="#mdl"><i class="fas fa-plus"></i> Agregar Rol</button>
            <div class="form-group m-3">
              <label for="keyWord">Buscar</label>
              <input type="text" wire:model="searchValue" class="form-control" id="searchValue" placeholder="Busqueda">
            </div>
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Usuarios</th>
                <th>Permisos</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($roles as $row)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ Str::upper(str_replace('-', ' ', $row->name)) }}</td>
                  <td><button class="btn btn-xs btn-primary" wire:click="viewUsers({{ $row->id }})"><i class="fa fa-users"></i> {{ $row->users->count() }}</button></td>
                  <td><button class="btn btn-xs btn-primary" wire:click="viewPermissions({{ $row->id }})"><i class="fa fa-key"></i> {{ $row->permissions->count() }}</button></td>
                  <td>
                    <button class="btn btn-xs btn-warning" wire:click="edit({{ $row->id }})"><i class="fa fa-edit"></i> Editar</button>
                    <button class="btn btn-xs btn-danger" onclick="destroy('{{ $row->id }}', 'Rol: {{ Str::upper(str_replace('-', ' ', $row->name)) }}')"><i class="fas fa-trash"></i> Eliminar</button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>

    @include('livewire.roles.modal')
    @include('livewire.roles.modal_users')
    @include('livewire.roles.modal_permisos')
</div>
