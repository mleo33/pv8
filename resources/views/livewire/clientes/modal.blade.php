<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ isset($cliente->id) ? "Editar Cliente" : "Agregar Cliente"}}</h4>
                <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="cliente.nombre">Nombre</label>
                            <input wire:model.defer="cliente.nombre" type="text" name="cliente.nombre" class="form-control" required />
                            @error('cliente.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                            <label for="cliente.direccion">Dirección</label>
                            <input wire:model.defer="cliente.direccion" type="text" name="cliente.direccion" class="form-control" required />
                            @error('cliente.direccion') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
            
                    <div class="form-row">

                        <div class="form-group col-md-7">
                            <div class="form-group">
                                <label for="cliente.correo">Correo Electrónico</label>
                                <input wire:model.defer="cliente.correo" type="email" name="cliente.correo" class="form-control" value="{{ old('cliente.correo') }}" />
                                @error('cliente.correo') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>


                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="cliente.limite_credito">Limite de Crédito</label>
                                <input style="text-align: right;" wire:model.defer="cliente.limite_credito" type="number" name="cliente.limite_credito" class="form-control" value="{{ old('cliente.limite_credito') }}" />
                                @error('cliente.limite_credito') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
            

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <div class="form-group">
                                <label for="telefono.tipo">Tipo de Teléfono</label>
                                <select wire:model.defer="telefono.tipo" class="form-control">
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
                                <input wire:model.defer="telefono.numero" type="number" name="telefono.numero" class="form-control" />
                                @error('telefono.numero') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label for="cliente.comentarios">Comentarios</label>
                        <textarea wire:model.defer="cliente.comentarios" type="text" name="cliente.comentarios" class="form-control"></textarea>
                        @error('cliente.comentarios') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                @if ($cliente->id)
                    <button type="button" wire:click.prevent="saveCliente()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="saveCliente()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>