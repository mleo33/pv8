<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{ $this->mdlName }}">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enviar Pedido</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Correos</label>
                <input type="text" wire:model="inputMails" class="form-control form-control-sm"/>
              </div>
              <div class="form-group">
                <label>Mensaje</label>
                <textarea wire:model="inputMailBody" rows="5" class="form-control form-control-sm"></textarea>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                
                <div wire:loading.remove wire:target="send">
                  <button wire:click="send" type="button" class="btn btn-success"><i class="fas fa-paper-plane"></i> Enviar</button>
                </div>
                <div wire:loading wire:target="send">
                  <button wire:click="send" type="button" disabled class="btn btn-info"><i class="fas fa-spin fa-spinner"></i> Enviando...</button>
                </div>
            </div>
        </div>
    </div>
</div>
