<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $this->sucursal->id ? "Editar" : "Agregar"}} Sucursal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="sucursal.nombre">Nombre</label>
                        <input wire:model="sucursal.nombre" style="text-transform: uppercase;" type="text" class="form-control" />
                        @error('sucursal.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="sucursal.direccion">Dirección</label>
                        <input wire:model="sucursal.direccion" style="text-transform: uppercase;" type="text" name="sucursal.direccion" class="form-control" />
                        @error('sucursal.direccion') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="sucursal.telefono">Teléfono</label>
                        <input wire:model="sucursal.telefono" style="text-transform: uppercase;" type="text" name="sucursal.telefono" class="form-control" />
                        @error('sucursal.telefono') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="sucursal.emisor_id">Emisor Fiscal</label>
                        <select wire:model="sucursal.emisor_id" class="form-control" />
                            <option value="0"></option>
                            @foreach ($emisores as $item)
                                <option value="{{$item->id}}">{{$item->nombre}} - {{$item->rfc}}</option>  
                            @endforeach
                        </select>
                        @error('sucursal.emisor_id') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-3">
                        <div>
                            <label for="sucursal.tasa_iva">Tasa IVA</label>
                            <input wire:model="sucursal.tasa_iva" type="number" style="text-align: center" class="form-control" min="0" max="50" />
                            @error('sucursal.tasa_iva') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sucursal.comentarios">Comentarios</label>
                        <textarea wire:model="sucursal.comentarios" type="text" class="form-control"></textarea>
                        @error('sucursal.comentarios') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                @if ($this->sucursal->id)
                    <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>