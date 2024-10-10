<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectProduct">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Seleccione Producto:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group m-3">
          <label>Buscar</label>
          <input type="text" wire:model.lazy="searchValueProductos" class="form-control" placeholder="Busqueda">
        </div>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Código</th>
              <th>Marca</th>
              <th>Descripción</th>
              <th>Unidad</th>
              <th>Existencia</th>
              <th>Precio</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($productos as $elem)
              <tr>
                <td>{{ $elem->id }}</td>
                <td>{{ $elem->codigo }}</td>
                <td>{{ $elem->marca }}</td>
                <td>{{ $elem->descripcion }}</td>
                <td>{{ $elem->unidad }}</td>

                @if ($elem->inventario_actual() != null)
                  <td>{{ $elem->inventario_actual()->qty_disponible() }}</td>
                  <td>@money($elem->inventario_actual()->precio)</td>
                  <td>
                    <button wire:click="setProduct({{ $elem->id }})" class="btn btn-sm btn-primary"><i class="fa fa-barcode"></i> Seleccionar</button>
                  </td>
                @else
                  <td>0</td>
                  <td>@money(0)</td>
                  <td>
                    @if ($selectMode ?? false)
                      <button wire:click="setProduct({{ $elem->id }})" class="btn btn-sm btn-primary"><i class="fa fa-barcode"></i> Seleccionar</button>
                    @else
                      NO DISPONIBLE
                    @endif
                  </td>
                @endif


              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
        {{ $productos->links() }}
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
  