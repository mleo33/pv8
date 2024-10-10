<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlPago">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pago a Venta #@paddy($this->venta->id)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
  
            <div class="modal-body">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                          <th width="50%">Forma de Pago</th>
                          <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr>
                          <td>
                              <select wire:model='pago.forma_pago' class="form-control">
                                  <option value="EFECTIVO">EFECTIVO</option>
                                  <option value="CHEQUE">CHEQUE</option>
                                  <option value="TARJETA">TARJETA</option>
                                  <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                              </select>
                          </td>
                          <td>
                              <input style="text-align: right;" type="number" step="0.01" min="0.00" class="form-control formaPago"
                              wire:model='pago.monto' autofocus />
                          </td>
                      </tr>
                    </tbody>
                </table>
  
                <br>
                <center>
                    <h2>Pagar @money($this->pago->monto)</h2>
                    @error('pago.monto') <span class="error text-danger">{{ $message }}</span> @enderror
                </center>
            </div>
  
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
              @php
                  $color = $this->pago->monto > 0 ? 'success' : 'danger';
                  $txt = $this->pago->monto > 0 ? 'PROCESAR PAGO' : 'Ingrese Monto';
                  $icon = $this->pago->monto > 0 ? 'fa-dollar-sign' : 'fa-times-circle';
              @endphp
              <button type="button" wire:click="registrarPago()" class="btn btn-{{$color}}" @if($this->pago->monto <= 0) disabled @endif><i class="fas {{$icon}}"></i> {{$txt}}</button>
            </div>
        </div>
    </div>
  </div>
  