<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlConfirmation">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Generar Factura</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                  <h5><b>Razón Social: </b>{{$this->factura_t->entidad_fiscal?->razon_social}}</h5>
                  <h5><b>RFC: </b>{{$this->factura_t->entidad_fiscal?->rfc}}</h5>
                  <h5><b>Sub-Total: </b>@money($this->factura_t->subtotal)</h5>
                  <h5><b>IVA (@float($this->factura_t->tasa_iva)%): </b>@money($this->factura_t->iva)</h5>
                  <h5><b>Total: </b>@money($this->factura_t->total_c_iva)</h5>
                  <br>
                    <center>
                        <h2>¿Desea continuar?</h2>
                    </center>
                </div>
            </div>

            
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
          <div wire:loading wire:target="generarFactura">
            <button disabled type="button" class="btn btn-info" disabled wire:click="generarFactura"><i class="fas fa-spin fa-spinner"></i> Timbrando Factura...</button>
          </div>
          <div wire:loading.remove wire:target="generarFactura">
              <button type="button" class="btn btn-success" wire:click="generarFactura"><i class="fas fa-check"></i> Crear Factura</button>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
</div>