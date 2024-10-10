<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlEnviarFactura">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enviar Factura</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="descripcionConcepto">Correo</label>
                        <input type="text" maxlength="255" wire:model="factura.entidad_fiscal.correo" class="form-control"></textarea>
                        @error('factura.entidad_fiscal.correo') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                <button type="button" data-to wire:click.prevent="enviarCorreo" class="btn btn-primary"><i class="fas fa-envelope"></i> Enviar</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>