<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlMarca">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Marca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="marca.nombre">Nombre</label>
                    <input wire:model.lazy="marca.nombre" style="text-transform: uppercase" type="text" class="form-control" />
                    @error('marca.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click="saveMarca()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>