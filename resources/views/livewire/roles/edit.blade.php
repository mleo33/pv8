@section('title', __('Roles de Usuarios'))
<div class="pt-4">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Editar Rol: {{ $role->name }}</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-hover projects">
            <a wire:click="cancel" class="btn btn-md btn-default mt-4 ml-3"><i class="fas fa-long-arrow-alt-left"></i> Regresar</a>
            <button wire:click="update" class="btn btn-md btn-primary mt-4 ml-3"><i class="fas fa-save"></i> Guardar Rol</button>
            <div class="form-group m-3">
              <label for="role.name">Nombre del Rol</label>
              <input type="text" wire:model="role.name" style="text-transform: uppercase;" class="form-control" placeholder="Nombre">
              @error('role.name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Activar Permiso</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($permissions as $row)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ Str::upper(str_replace('-', ' ', $row->name)) }}</td>
                  <td>
                    <label class="content-input">
                        <input type="checkbox" wire:model="permisos.{{$loop->index}}" value="{{ $row->id }}"/>
                        <i></i>
                    </label>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>
</div>

