<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $updateMode ? "Editar Proveedor" : "Agregar Proveedor"}}</h4>
                <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" wire:model="selected_id">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input wire:model="nombre" type="text" name="nombre" class="form-control" required />
                        @error('nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
            
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <div class="form-group">
                                <label for="calle">Calle</label>
                                <input wire:model="calle" type="text" name="calle" class="form-control" required />
                                @error('calle') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
            
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="numero">Numero</label>
                                <input wire:model="numero" type="text" name="numero" class="form-control" value="{{ old('numero') }}" required />
                                @error('numero') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
            
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label for="numero_int">Numero Interior</label>
                                <input wire:model="numero_int" type="text" name="numero_int" class="form-control" value="{{ old('numero_int') }}" />
                                @error('numero_int') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
            
                        <div class="form-group col-md-8">
                            <div class="form-group">
                                <label for="colonia">Colonia</label>
                                <input wire:model="colonia" type="text" name="colonia" class="form-control" value="{{ old('colonia') }}" required />
                                @error('colonia') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
            
                    <div class="form-row">
                        <div class="form-group col-md-4">
                        <div class="form-group">
                            <label for="cp">Código Postal</label>
                            <input wire:model="cp" type="text" name="cp" class="form-control" value="{{ old('cp') }}" />
                            @error('cp') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        </div>
            
                        <div class="form-group col-md-4">
                        <div class="form-group">
                            <label for="ciudad">Ciudad</label>
                            <input wire:model="ciudad" type="text" name="ciudad" class="form-control" value="{{ old('ciudad') }}" />
                            @error('ciudad') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        </div>
            
                        <div class="form-group col-md-4">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input wire:model="estado" type="text" name="estado" class="form-control" value="{{ old('estado') }}" />
                            @error('estado') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        </div>
                    </div>
            
                    <div class="form-row">
                        <div class="form-group col-md-3">
                        <div class="form-group">
                            <label for="rfc">RFC</label>
                            <input wire:model="rfc" type="text" name="rfc" class="form-control" value="{{ old('rfc') }}" />
                            @error('rfc') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        </div>
            
                        <div class="form-group col-md-4">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input wire:model="telefono" type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" required />
                            @error('telefono') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        </div>
            
                        <div class="form-group col-md-5">
                        <div class="form-group">
                            <label for="correo">Correo Electrónico</label>
                            <input wire:model="correo" type="email" name="correo" class="form-control" value="{{ old('correo') }}" />
                            @error('correo') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label for="comentarios">Comentarios</label>
                        <textarea wire:model="comentarios" type="text" name="comentarios" class="form-control" value="{{ old('comentarios') }}"></textarea>
                        @error('comentarios') <span class="error text-danger">{{ $message }}</span> @enderror
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