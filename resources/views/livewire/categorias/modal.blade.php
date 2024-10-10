<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $updateMode ? "Editar Categoria" : "Agregar Categoria"}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" wire:model="selected_id">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input wire:model="nombre" style="text-transform: uppercase;" type="text" name="nombre" class="form-control" required />
                        @error('nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                @if ($updateMode)
                    <button type="button" wire:click.prevent="update()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="store()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>