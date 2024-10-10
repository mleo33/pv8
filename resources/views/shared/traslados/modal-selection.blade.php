<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectRoute">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Seleccione Traslado:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group m-3">
          <label>Buscar</label>
          <input type="text" wire:model="searchValueTraslados" class="form-control" placeholder="Busqueda">
        </div>
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th>#</th>
              <th>Destino</th>
              <th>Sencillo</th>
              <th>Redondo</th>
              <th>Comentarios</th>
            </tr>
          </thead>
          <tbody>
            @foreach($traslados as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->destino }}</td>
                <td><button wire:click="agregarTraslado({{$item->id}},'SENCILLO')" class="btn btn-sm btn-primary">@money($item->sencillo)</button></td>
                <td><button wire:click="agregarTraslado({{$item->id}},'REDONDO')" class="btn btn-sm btn-primary">@money($item->redondo)</button></td>
                <td>{{ $item->comentarios }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
  