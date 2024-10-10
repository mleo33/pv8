<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Seleccione Cliente:</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              @if ($this->createMode)
                  <div class="m-2">
                      <button wire:click="$set('createMode', false)" class="btn btn-xs btn-secondary"><i class="fa fa-arrow-left"></i> Regresar</button>
                  </div>
                  <div>

                      <div class="row justify-content-md-center">
                          <div class="col-8">
                              <div class="row">
                                  <div class="form-group col">
                                      <label>Nombre</label>
                                      <input wire:model.defer="cliente.nombre" type="text" class="form-control" required />
                                      @error('cliente.nombre')
                                          <span class="error text-danger">{{ $message }}</span>
                                      @enderror
                                  </div>
      
                              </div>
      
                              <div class="row">
                                  <div class="form-group col">
                                      <label>Dirección</label>
                                      <input wire:model.defer="cliente.direccion" type="text" class="form-control" />
                                      @error('cliente.direccion')
                                          <span class="error text-danger">{{ $message }}</span>
                                      @enderror
                                  </div>
                              </div>
      
                              <div class="row">
                                  <div class="form-group col-6">
                                      <label>Correo Electrónico</label>
                                      <input wire:model.defer="cliente.correo" type="text" class="form-control" />
                                      @error('cliente.correo')
                                          <span class="error text-danger">{{ $message }}</span>
                                      @enderror
                                  </div>
      
                                  <div class="form-group col-4">
                                      <label>Limite de Crédito</label>
                                      <input wire:model.defer="cliente.limite_credito" style="text-align: right;" type="text" class="form-control" />
                                      @error('cliente.limite_credito')
                                          <span class="error text-danger">{{ $message }}</span>
                                      @enderror
                                  </div>
      
                                  <div class="form-group col-2">
                                      <label>Días de Crédito</label>
                                      <input wire:model.defer="cliente.dias_credito" style="text-align: right;" type="text" class="form-control" />
                                      @error('cliente.dias_credito')
                                          <span class="error text-danger">{{ $message }}</span>
                                      @enderror
                                  </div>
                              </div>
      
                              <div class="row">
                                  <div class="col-5">
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
          
                                  <div class="col-7">
                                      <div class="form-group">
                                          <label for="telefono.numero">Número</label>
                                          <input wire:model="telefono.numero" type="number" name="telefono.numero" class="form-control" />
                                          @error('telefono.numero') <span class="error text-danger">{{ $message }}</span> @enderror
                                      </div>
                                  </div>
                              </div>
                      
                              <div class="row">
                                  <div class="col">
                                      <label for="cliente.comentarios">Comentarios</label>
                                      <textarea wire:model="cliente.comentarios" type="text" name="cliente.comentarios" class="form-control"></textarea>
                                      @error('cliente.comentarios') <span class="error text-danger">{{ $message }}</span> @enderror
                                  </div>
                              </div>
                          </div>
                      </div>



                  </div>
              @else
                  <div class="form-group m-3">
                      <label for="keyWord">Buscar</label>
                      <input type="text" wire:model.lazy="keyWord" class="form-control" placeholder="Busqueda">
                  </div>
                  <div class="m-2">
                      <button wire:click="$set('createMode', true)" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Crear Cliente</button>
                  </div>         
                  <table class="table table-hover">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>Nombre</th>
                              <th>Dirección</th>
                              <th>Seleccionar</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($clientes as $item)
                          <tr>
                              <td>{{$item->id_paddy}}</td>
                              <td>{{$item->nombre}}</td>
                              <td>{{$item->direccion}}</td>
                              <td><button wire:click="select({{$item->id}})" class="btn btn-xs btn-secondary"><i class="fa fa-check"></i> Seleccionar</button></td>
                          </tr>    
                          @endforeach
                          
                      </tbody>
                  </table>
              @endif
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fas fa-window-close"></i> Cancelar</button>
              @if ($this->createMode)
                  <button type="button" wire:click="create" class="btn btn-success"><i class="fas fa-check"></i> Crear Cliente</button>
              @else
                  {{$clientes->links()}}
              @endif
          </div>
      </div>
      <!-- /.modal-content -->
  </div>
</div>





