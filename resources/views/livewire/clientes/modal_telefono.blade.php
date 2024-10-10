<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlTelefono">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ isset($telefono->id) ? "Editar Teléfono" : "Agregar Teléfono"}}</h4>
                <button type="button" wire:click.prevent="cancelTelefono()" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="telefono.tipo">Tipo de Teléfono</label>
                                <select wire:model="telefono.tipo" class="form-control">
                                    <option value="CELULAR">CELULAR</option>
                                    <option value="OFICINA">OFICINA</option>
                                    <option value="CASA">CASA</option>
                                </select>
                                @error('telefono.tipo') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>


                        <div class="form-group col-md-7">
                            <div class="form-group">
                                <label for="telefono.numero">Número</label>
                                <input wire:model="telefono.numero" type="number" name="telefono.numero" class="form-control" />
                                @error('telefono.numero') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label for="telefono.notas">Notas</label>
                        <textarea wire:model="telefono.notas" maxlength="255" type="text" name="telefono.notas" class="form-control"></textarea>
                        @error('telefono.notas') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" wire:click.prevent="cancelTelefono" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                @if ($telefono->id)
                    <button type="button" wire:click.prevent="saveTelefono()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="saveTelefono()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>