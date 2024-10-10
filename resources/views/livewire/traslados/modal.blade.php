<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $this->traslado->id ? "Editar Traslado" : "Agregar Traslado"}}</h4>
                <button wire:click="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="traslado.destino">Destino</label>
                        <input wire:model="traslado.destino" style="text-transform: uppercase;" type="text" name="traslado.destino" class="form-control" />
                        @error('traslado.destino') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                            <label for="traslado.sencillo">Viaje Sencillo</label>
                            <input wire:model="traslado.sencillo" style="text-align: right;" type="number" name="traslado.sencillo" class="form-control" />
                            @error('traslado.sencillo') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
    
                        <div class="form-group col">
                            <label for="traslado.redondo">Viaje Redondo</label>
                            <input wire:model="traslado.redondo" style="text-align: right;" type="number" name="traslado.redondo" class="form-control" />
                            @error('traslado.redondo') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="traslado.comentarios">Comentarios</label>
                        <textarea wire:model="traslado.comentarios" type="text" name="traslado.comentarios" class="form-control"></textarea>
                        @error('traslado.comentarios') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" wire:click.prevent="cancel" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                @if ($this->traslado->id)
                    <button type="button" wire:click.prevent="save" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="save" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>