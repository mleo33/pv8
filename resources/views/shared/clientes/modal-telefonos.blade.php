<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlTelefonos">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Teléfonos {{$this->cliente->nombre}}:</h4>
        <button wire:click="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tipo</th>
                  <th>Número</th>
                  <th>Notas</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($this->cliente->telefonos as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tipo }}</td>
                    <td>{{ $item->numero }}</td>
                    <td>{{ $item->notas }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
      </div>
      <div class="modal-footer justify-content-between">
        <button wire:click="cancel" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
  