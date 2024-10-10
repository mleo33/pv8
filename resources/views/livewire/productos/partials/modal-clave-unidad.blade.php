<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlClaveUnidad">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Clave de Unidad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Clave</label>
                        <input wire:model.lazy="claveUnidad.clave" style="text-transform: uppercase;" type="text" class="form-control" required />
                        @error('claveUnidad.clave') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="claveUnidad.nombre">Nombre</label>
                        <input wire:model.lazy="claveUnidad.nombre" type="text" class="form-control" required />
                        @error('claveUnidad.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click="saveClaveUnidad()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>