<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlPagoCredito">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Monto Renta: @money($this->renta_t->total())</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>

          <div class="modal-body">
              <table class="table table-striped projects">
                  <thead>
                      <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Propietario</th>
                        <th>Importe</th>
                        <th width="15%">Pagar</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($this->renta_t->registros as $key => $elem)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$elem->descripcion()}}</td>
                          <td>{{$elem->model->propietario ?? 'N/A'}}</td>
                          <td>@money($elem->importe())</td>
                          <td>
                              <input onclick="this.select()" wire:change="saveRegistro({{$key}})" style="text-align: right;" type="number" step="0.01" min="0.00" class="form-control @if($loop->first) formaPago @endif"
                              wire:model='renta_t.registros.{{ $loop->index }}.pagado'/>
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>

              {{-- <div class="d-flex justify-content-between">
                  @if (count($formas_pago_restantes) > 0)
                  <button wire:click="addFormaPago()" class="btn btn-xs btn-primary"><i class="fas fa-plus"></i> Pago con
                      varias formas</button>
                  @endif
              </div> --}}

              <br>
              <center>
                  <?php 
                    $montoRenta = $this->renta_t->total();
                    $creditoDisponible = $this->renta_t->cliente->credito_disponible();
                    $pagoMinimo = $creditoDisponible <= 0 ? $montoRenta : ($montoRenta - $creditoDisponible);
                    $pagoMinimo = $pagoMinimo <= 0 ? 0 : $pagoMinimo;
                    // $pagoTotal = $formas_pago_renta->sum('monto');
                    // $pagoTotal = $formas_pago_renta->reduce(function($carry, $elem){
                    //     $monto = $elem['monto'] ? $elem['monto'] : 0;
                    //     return $carry + $monto;
                    // });
                    // $pagoTotal = $formas_pago_renta[0]['monto'] ? $formas_pago_renta[0]['monto'] : 0;
                    $pagoTotal = 0;
                    foreach ($this->renta_t->registros as $value) {
                        $pagoTotal += $value->pagado;
                    }
                    
                    $pendiente = $pagoTotal - $montoRenta;
                    $mensaje = $pendiente > 0 ? 'A favor:':'Pendiente:';
                  ?>

                    <h2>Pagar: @money($pagoTotal)</h2>
                    <h3>{{ $mensaje }} @money(abs($pendiente))</h3>
                  
                  @if ($creditoDisponible > 0)
                    <h5 style="color: green;">Crédito Disponible: @money($creditoDisponible)</h5>
                    <h5>Pago Mínimo: @money($pagoMinimo)</h5>
                  @endif
              </center>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
            @php
                $generarRenta = $pagoTotal >= $pagoMinimo;
                $color = $generarRenta ? 'success' : 'danger';
                $txt = $generarRenta ? 'Continuar' : 'Saldo Pendiente';
                $icon = $generarRenta ? 'fa-check' : 'fa-times-circle';
            @endphp
            <button type="button" wire:click="metodosPago()" data-dismiss="modal" class="btn btn-{{$color}}" @if(!$generarRenta) disabled @endif><i class="fas {{$icon}}"></i> {{$txt}}</button>
          </div>
      </div>
  </div>
</div>
