<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlPagoCredito">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Cliente con crédito disponible</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>

          <div class="modal-body">
            <center>
                <?php 
                    $totalVenta = $this->venta_t->total();
                    $pagoTotal = 0;
                    foreach ($formas_pago_venta as $elem) {
                        $pagoTotal += $elem['monto'] ? $elem['monto'] : 0;
                    }
                    $creditoDisponible = $this->venta_t->cliente->credito_disponible();
                    $pagoMinimo = $this->venta_t->pagoMinimo($creditoDisponible);

                    $pendiente = $totalVenta - $this->venta_t->PagoRequerido;
                    $mensaje = $pendiente > 0 ? 'A favor:':'Pendiente:';

                    $continuar = $this->venta_t->PagoRequerido >= $pagoMinimo;
                ?>
                <h2>Total venta: @money($totalVenta)</h2>
                <h3>Crédito Disponible: @money($creditoDisponible)</h3>
                <h3>Pago Mínimo: @money($pagoMinimo)</h3>

                <br>
                <br>
                <div class="form-group">
                    <label for="referencia.nombre">Monto a Pagar</label>
                    <input wire:keydown.enter="metodosPago" wire:model="venta_t.PagoRequerido" style="width: 50%; text-align: center" type="number" id="iptPagoRequerido" onClick="this.select();" class="form-control form-control-lg" />
                    @error('referencia.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                @if ($pendiente > 0)
                    <h4>Saldo Pendiente: @money($pendiente)</h4>
                @else
                    <h4 class="text-success"><b>PAGAR TOTAL DE VENTA</b></h4>
                @endif
            </center>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
            @if ($continuar)
                <button type="button" wire:click="metodosPago()" class="btn btn-success"><i class="fa fa-check"></i> Continuar</button>
            @else
                <button type="button" wire:click="metodosPago()" disabled class="btn btn-danger"><i class="fa fa-times-circle"></i> Pago mínimo requerido</button>
            @endif
          </div>
      </div>
  </div>
</div>