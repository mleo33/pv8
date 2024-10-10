<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectEquipment">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Seleccione Equipo:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group m-3">
          <label>Buscar</label>
          <input type="text" wire:keydown="resetPage()" wire:model="searchValueEquipos" class="form-control" placeholder="Busqueda">
        </div>
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th>ID</th>
              <th>FUA</th>
              <th>Familia</th>
              <th>Descripción</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($equipos as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->fua }}</td>
                <td>{{ $item->familia->nombre }}</td>
                <td>{{ $item->descripcion }}</td>
                @if ($item->disponible() > 0 || !($validateAvailable ?? true))
                  <td>
                    <button wire:click="mdlPrecioRentas({{ $item->id }})" class="btn btn-sm btn-primary"><i class="fa fa-caravan"></i> Seleccionar</button>
                  </td>
                @else
                  <td>NO DISPONIBLE</td>
                @endif

              </tr>
            @endforeach
          </tbody>
        </table>

        {{ $equipos->links() }}
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
  