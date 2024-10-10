<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="row">
          <div class="col-12">
              <div class="card m-0">
      
                  <div class="card-header d-flex p-0">
                      <h3 class="pl-3 pt-3">Sucursal: {{$this->sucursal->nombre}}</h3>
                      <ul class="nav nav-pills ml-auto p-2">
                          <li class="nav-item"><a class="nav-link {{ $activeTab == 1 ? 'active' : ''}}" wire:click="$set('activeTab',1)" href="#"><i class="fas fa-store"></i> Información General</a></li>
                          <li class="nav-item"><a class="nav-link {{ $activeTab == 2 ? 'active' : ''}}" wire:click="$set('activeTab',2)" href="#"><i class="fas fa-print"></i> Tickets</a></li>
                          <li class="nav-item"><a data-dismiss="modal" wire:click="cancel" class="nav-link" style="cursor: pointer;"><i class="fas fa-times"></i> Cerrar</a></li>
                      </ul>
                  </div>
                  
                  <div class="card-body p-0">
                      <div class="tab-content">
                        <div class="tab-pane {{ $activeTab == 1 ? 'active' : ''}}" id="tab_1">
                            <div class="card m-0">
                                <div class="card-body">
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
                                            {{-- <input wire:model="sucursal.tasa_iva" type="number" style="text-align: center" class="form-control" min="0" max="50" /> --}}
                                            <select wire:model="sucursal.tasa_iva" class="form-control">
                                                <option value=0></option>
                                                <option value=8.00>8.00 %</option>
                                                <option value=16.00>16.00 %</option>
                                            </select>
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
                                
                                <div class="card-footer">
                                    @if ($this->sucursal->id)
                                        <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                                    @else
                                        <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane {{ $activeTab == 2 ? 'active' : ''}}" id="tab_1">
                            <div class="card m-0">
                                <div class="card-body">
                                <form>
                                    <div class="form-group">
                                        <label for="sucursal.mensaje_ticket_venta">Ticket de Venta</label>
                                        <textarea wire:model="sucursal.mensaje_ticket_venta" style="width: 50%;" rows="5" type="text" class="form-control"></textarea>
                                        @error('sucursal.mensaje_ticket_venta') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </form>
                                </div>
                                
                                <div class="card-footer">
                                    @if ($this->sucursal->id)
                                        <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                                    @else
                                        <button type="button" wire:click.prevent="save()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                      <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                  </div>
              </div>
          </div>
      </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </div>
  