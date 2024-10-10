<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlDescuentoRegistro">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Aplicar Descuento</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>

          <div class="modal-body">
            <center>
                <div class="form-group">
                    <small>{{$this->selectedRegistroTemporal?->descripcion}}</small>
                    <br />
                    <br />
                    <label>Descuento (%)</label>
                    <br />
                    <input type="text" style="text-align: center" class="form-control" wire:keydown.enter="aplicarDescuentoRegistro" wire:model.defer="selectedRegistroTemporal.descuento" onkeypress="return event.charCode >= 46 && event.charCode <= 57" />
                    @error('selectedRegistroTemporal.descuento')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </center>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
            <button class="btn btn-success" wire:click="aplicarDescuentoRegistro"><i class="fas fa-check"></i> Aceptar</button>
        
          </div>
      </div>
  </div>
</div>
