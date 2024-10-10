<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cantidad</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <center>
            <div class="form-group">
              <label>Ingrese Cantidad:</label>
              <input wire:keydown.enter="select" wire:model.defer="qty" onclick="this.select()" onkeypress="return event.charCode >= 46 && event.charCode <= 57"  type="text" class="form-control" style="text-align: center;"/>
            </div>
          </center>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
          <button type="button" class="btn btn-success" wire:click="select"><i class="fas fa-check"></i> Aceptar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
</div>

