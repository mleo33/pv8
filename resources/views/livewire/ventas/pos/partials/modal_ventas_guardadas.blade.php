<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlVentasGuardadas">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Ventas Guardadas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>

          <div class="modal-body p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th></th>
                  <th>#</th>
                  <th>Cliente</th>
                  <th>Productos</th>
                  <th>Total</th>
                  <th>Selecc.</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($this->saved_sales as $item)
                  <tr>
                    <td>
                      <button class="btn btn-xs btn-danger" wire:click="eliminarVentaGuardada({{$item->id}})"><i class="fas fa-times"></i></button>
                    </td>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->cliente?->nombre ?? "N/A"}}</td>
                    <td>{{$item->totalProductos()}}</td>
                    <td>@money($item->total())</td>
                    <td>
                      <button class="btn btn-xs btn-primary" wire:click="cargarVentaGuardada({{$item->id}})"><i class="fas fa-check"></i> Seleccionar</button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            @if ($this->venta_t->totalProductos() > 0)
              <button type="button" class="btn btn-success" wire:click="guardarVenta(false)"><i class="fas fa-save"></i> Nueva Venta</button>
            @endif
          </div>
      </div>
  </div>
</div>
