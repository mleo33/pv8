<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Seleccione Ventas</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col">
                      <div class="form-group">
                          <label for="keyWord">Buscar</label>
                          <input type="text" wire:model.lazy="keyWord" class="form-control" placeholder="Busqueda">
                      </div>
                  </div>
              </div>
              
              <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID Venta</th>
                        <th>Fecha</th>
                        <th>Vendedor</th>
                        <th>Cliente</th>
                        <th>Productos</th>
                        <th>Monto</th>
                        <th>Seleccionar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($ventas as $item)
                    <tr>
                        <td> @paddy($item->id) </td>
                        <td>{{ $item->fecha_format() }}</td>
                        <td>{{ $item->usuario->name }}</td>
                        <td>{{ $item->cliente->nombre ?? 'NO IDENTIFICADO' }}</td>
                        <td><button wire:click="viewRegistros({{$item->id}})" class="btn btn-sm btn-primary"><i class="fas fa-shopping-basket"></i> <b>{{ $item->totalProductos() }}</b></button></td>
                        <td>@money($item->total())</td>
                        <th>        
                            <label class="content-input">
                                <input type="checkbox" wire:model.defer="selectedIds.{{$item->id}}" />
                                <i></i>
                          </label>
                        </th>
                    </tr>
                @endforeach
                </tbody>
              </table>
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fas fa-window-close"></i> Cancelar</button>
              {{$ventas->links()}}
              <button type="button" wire:click="select" class="btn btn-success"><i class="fas fa-check"></i> Aceptar</button>
          </div>
      </div>
  </div>
</div>





