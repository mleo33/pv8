<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlUsers">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Usuarios con rol: {{ $role->name }}</h4>
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
                        <th>Sucursal</th>
                        <th>Correo</th>
                        {{-- <th>Rol asignado</th> --}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($role->users as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->sucursal->nombre }}</td>
                            <td>{{ $row->email }}</td>
                            {{-- <td>
                                <label class="content-input">
                                    <input type="checkbox">
                                    <i></i>
                                </label>
                            </td> --}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                <!-- @if (isset($role->id))
                    <button type="button" wire:click.prevent="update()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="update()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif -->
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>