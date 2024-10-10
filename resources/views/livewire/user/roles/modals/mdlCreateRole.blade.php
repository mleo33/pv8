<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCreateRole">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" style="text-transform: uppercase" wire:model="selectedRole.name" class="form-control">
                    @error('selectedRole.name') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fas fa-window-close"></i> Cancelar</button>
                <button wire:click="createRole" type="button" class="btn btn-success"><i class="fas fa-user-shield"></i> Crear Rol</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>