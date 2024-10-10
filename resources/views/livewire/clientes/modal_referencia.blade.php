<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlReferencia">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ isset($referencia->id) ? "Editar" : "Agregar"}} Referencia</h4>
                <button type="button" wire:click.prevent="cancelTelefono()" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="referencia.nombre">Nombre</label>
                            <input wire:model="referencia.nombre" style="text-transform: uppercase;" type="text" class="form-control" />
                            @error('referencia.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                            <label for="referencia.direccion">Dirección</label>
                            <input wire:model="referencia.direccion" maxlength="255" type="text" class="form-control" />
                            @error('referencia.direccion') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                            <div class="form-group">
                                <label for="referencia.telefono1">Teléfono 1</label>
                                <input wire:model="referencia.telefono1" maxlength="15" type="text" class="form-control" />
                                @error('referencia.telefono1') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group col">
                            <div class="form-group">
                                <label for="referencia.telefono2">Teléfono 2</label>
                                <input wire:model="referencia.telefono2" maxlength="15" type="text" class="form-control" />
                                @error('referencia.telefono2') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                            <label for="referencia.notas">Notas</label>
                            <textarea wire:model="referencia.notas" maxlength="255" type="text" class="form-control"></textarea>
                            @error('referencia.notas') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" wire:click.prevent="cancelReferencia" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                @if ($referencia->id)
                    <button type="button" wire:click.prevent="saveReferencia()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="saveReferencia()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>