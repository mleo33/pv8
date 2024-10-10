<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlInventarioSucursales">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Inventario: {{ $producto->codigo . " / " . $producto->descripcion }}</h4>
        <button type="button" wire:click="cancel" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th>#</th>
              <th>Sucursal</th>
              <th>Mínimo</th>
              <th>Existencia</th>
              <th>Precio</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($sucursalesInventario as $inv)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $inv->nombre ?? '' }}</td>
                @if (isset($inv->minimo) && $inv->minimo > $inv->existencia)
                  <td style="color: red;"> {{ $inv->minimo ?? 0 }}</td>
                @else
                  <td> {{ $inv->minimo ?? 0 }}</td>
                @endif
                <td>{{ $inv->existencia ?? 0 }}</td>
                <td>@money($inv->precio ?? 0)</td>
                <td>
                  <button class="btn btn-sm btn-warning" wire:click="editInventario({{ json_encode($inv) }})"><i class="fa fa-edit"></i> Editar</button>
                </td>
              </tr>

              
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
