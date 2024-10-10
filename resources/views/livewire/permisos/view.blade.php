@section('title', __('Roles de Usuarios'))
<div class="pt-4">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Permisos de sistema</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
            <div class="form-group m-3">
              <label for="keyWord">Buscar</label>
              <input type="text" wire:model="searchValue" class="form-control" id="searchValue" placeholder="Busqueda">
            </div>
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Roles</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($permissions as $row)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ Str::upper(str_replace('-', ' ', $row->name)) }}</td>
                  <td><button class="btn btn-xs btn-primary" wire:click="viewRoles({{ $row->id }})"><i class="fa fa-user-tie"></i> {{ $row->roles->count() }}</button></td>
                </tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>

    @include('livewire.permisos.modal_users')
    @include('livewire.permisos.modal_roles')
</div>