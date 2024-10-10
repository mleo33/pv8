<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlComentario">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agregar Comentario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="cliente.comentarios">Comentarios</label>
                        <textarea maxlength="255" wire:model="comentario.mensaje" type="text" class="form-control"></textarea>
                        @error('comentario.mensaje') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" wire:click.prevent="agregarComentario()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>