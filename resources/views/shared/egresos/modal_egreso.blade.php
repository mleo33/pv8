<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlEgreso">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Registrar Egreso</h4>
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
                            <select wire:model='egreso.forma_pago' class="form-control">
                                <option value="EFECTIVO">EFECTIVO</option>
                                <option value="CHEQUE">CHEQUE</option>
                                <option value="TARJETA DEBITO">TARJETA DEBITO</option>
                                <option value="TARJETA CREDITO">TARJETA CREDITO</option>
                                <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                            </select>
                        </td>
                        <td>
                            <input style="text-align: right;" type="number" step="0.01" min="0.00" class="form-control formaPago"
                            wire:model='egreso.monto' autofocus />
                        </td>
                    </tr>
                  </tbody>
              </table>
              @error('egreso.monto') <span class="error text-danger">{{ $message }}</span> @enderror

            <div class="form-group">
                <label for="egreso.concepto">Concepto de Egreso</label>
                <textarea maxlength="255" wire:model="egreso.concepto" type="text" class="form-control"></textarea>
                @error('egreso.concepto') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

              <br>
              <center>
                  @php
                      $monto = $this->egreso->monto;
                      $monto = $monto ? $monto : 0;
                      $this->egreso->monto = $monto;
                  @endphp
                  <h2>Retirar: @money($monto)</h2>
              </center>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
            <button type="button" wire:click="registrarEgreso()" class="btn btn-danger"><i class="fas fa-hand-holding-usd"></i> Registrar Egreso</button>
          </div>
      </div>
  </div>
</div>
