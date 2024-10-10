<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlEnviarPedido">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-scrollable modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Crear Pedido</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5><b>Proveedor:</b> {{$this->pedido_t->proveedor->nombre}}</h5>
            <h5><b>Productos:</b> @qty($this->pedido_t->total_productos)</h5>
            <h5><b>Importe:</b> @money($this->pedido_t->total)</h5>
            <br>
            <div class="form-group">
                <label>Enviar pedido por correo:</label>
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
          <div wire:loading.remove wire:target="crearPedido">
            <button wire:click="crearPedido" type="button" class="btn btn-success"><i class="fas fa-check"></i> Crear Pedido</button>
          </div>
          <div wire:loading wire:target="crearPedido">
            <button type="button" class="btn btn-info"><i class="fas fa-spinner fa-spin"></i> Procesando...</button>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
</div>