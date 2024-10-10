<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlDescuento">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Descuento Global</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>

          <div class="modal-body">
            <center>
                <div class="form-group">
                    <label>Descuento (%)</label>
                    <input type="number" style="text-align: center" class="form-control" wire:model.defer="descuento" onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                    @error('descuento')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </center>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
            <button class="btn btn-success" wire:click="aplicarDescuento"><i class="fas fa-check"></i> Aceptar</button>
        
          </div>
      </div>
  </div>
</div>
