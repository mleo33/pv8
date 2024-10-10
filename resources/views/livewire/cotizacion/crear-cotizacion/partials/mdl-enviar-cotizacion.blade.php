<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlEnviarCotizacion">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-scrollable modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Crear Cotización</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5><b>Cliente:</b> {{$this->cotizacion_t->cliente->nombre ?? "PUBLICO EN GENERAL"}}</h5>
            <h5><b>Productos:</b> @qty($this->cotizacion_t->cantidad_conceptos)</h5>
            <h5><b>Importe:</b> @money($this->cotizacion_t->total)</h5>
            <br>
            <div class="form-group">
                <label>Enviar cotización por correo:</label>
                <x-input-checkbox model="sendEmail"/>
                @if ($this->sendEmail)
                  <div class="form-group">
                    <label>Correo:</label>
                    <input type="text" class="form-control form-control-sm" wire:model.lazy="inputEmails" style="text-transform: lowercase"/>
                  </div>
                  <div class="form-group">
                    <label>Mensaje:</label>
                    <textarea class="form-control form-control-sm" rows="5" wire:model.lazy="inputMessage"></textarea>
                  </div>
                @endif
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
          <div wire:loading.remove wire:target="crearCotizacion">
            <button wire:click="crearCotizacion" type="button" class="btn btn-success"><i class="fas fa-check"></i> Crear Cotización</button>
          </div>
          <div wire:loading wire:target="crearCotizacion">
            <button type="button" class="btn btn-info"><i class="fas fa-spinner fa-spin"></i> Procesando...</button>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
</div>