<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlRoles">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Roles con permiso: {{ $permission->name }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click.prevent="cancel()">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Usuarios</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($permission->roles as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::upper(str_replace('-', ' ', $row->name)) }}</td>
                            <td><button class="btn btn-xs btn-primary" wire:click="viewUsers({{ $row->id }})"><i class="fa fa-users"></i> {{ $row->users->count() }}</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                <!-- @if (isset($permission->id))
                    <button type="button" wire:click.prevent="update()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="update()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif -->
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>