<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlComentarioCancelacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{$title ?? 'Cancelar'}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="cliente.comentarios">{{$text ?? 'Ingrese motivos de cancelación'}}</label>
                        <textarea maxlength="255" wire:model="comentario.mensaje" type="text" class="form-control"></textarea>
                        @error('comentario.mensaje') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                <button type="button" wire:click.prevent="confirmCancel()" class="btn btn-danger"><i class="fas fa-times"></i> Cancelar</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>