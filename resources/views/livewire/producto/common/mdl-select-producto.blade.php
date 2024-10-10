<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Seleccione Producto</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-6">
                      <div class="form-group">
                          <label for="keyWord">Buscar</label>
                          <input type="text" wire:model.lazy="keyWord" class="form-control" placeholder="Busqueda">
                      </div>
                  </div>
                  <div class="col-3">
                      <div class="form-group">
                          <label for="keyWord">Marcas</label>
                          <select wire:model="selectedMarca" class="form-control">
                              <option value="">--TODAS--</option>
                              @foreach ($marcas as $item)
                                  <option value="{{$item->nombre}}">{{$item->nombre}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="col-3">
                      <div class="form-group">
                          <label for="keyWord">Categorias</label>
                          <select class="form-control" wire:model="selectedCategoria">
                              <option value="">--TODAS--</option>
                              @foreach ($categorias as $item)
                                  <option value="{{$item->nombre}}">{{$item->nombre}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              </div>
              
              <table class="table table-hover">
                  <thead>
                      <tr>
                          <th>Código</th>
                          <th>Descripción</th>
                          <th>Marca</th>
                          <th>Existencia</th>
                          <th>{{ucfirst($this->priceField)}}</th>
                          <th>Seleccionar</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($data as $item)
                      @php
                          $stock = $item->current_inventory?->existencia ?? 0;
                      @endphp
                      <tr>
                          <td>{{$item->codigo}}</td>
                          <td>{{$item->descripcion}}</td>
                          <td>{{$item->marca}}</td>
                          <td>{{$stock}}</td>
                          <td>@money($item->current_inventory[$this->priceField] ?? 0)</td>
                          <td>
                              @if ($this->stockValidation && $stock <= 0)
                                  N/A
                              @else
                                  <button wire:click="select({{$item->id}})" class="btn btn-xs btn-success"><i class="fa fa-barcode"></i> Seleccionar</button>
                              @endif
                          </td>
                      </tr>    
                      @endforeach                        
                  </tbody>
              </table>
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fas fa-window-close"></i> Cerrar</button>
              {{$data->links()}}
          </div>
      </div>
  </div>
</div>





