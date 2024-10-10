<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->modalCashPayment}}">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pagar: @money($this->paymentAmount)</h5>
                <button type="button" class="close" data-toggle="modal" data-target="#{{$this->modalCashPayment}}" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                        <th></th>
                        <th width="50%">Forma de Pago</th>
                        <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                          @foreach ($this->formas_pago as $key => $elem)
                              
                          <tr>
                              <td>
                                  @if (!$loop->first)
                                      <button wire:click="removeFormaPago({{ $loop->index }})" class='btn btn-danger btn-xs'>
                                          <i class="fas fa-minus"></i>
                                      </button>
                                  @endif
                              </td>
                              <td>
                                  <select wire:model='formas_pago.{{ $key }}.forma' class="form-control">
                                      <option wire:key="{{ $key . $elem['forma'] }}" value="{{  $elem['forma'] }}">{{  $elem['forma'] }}</option>
                                      @foreach ($this->formasPagoRestantes() as $f)
                                      <option wire:key="{{ $key . $f }}" value="{{ $f }}">{{ $f }}</option>
                                      @endforeach
                                  </select>
                              </td>
                              <td>
                                  <input onclick="this.select()" style="text-align: right;" type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" class="form-control formaPago"
                                  wire:model='formas_pago.{{ $loop->index }}.monto' autofocus />
                              </td>
                          </tr>
                          @endforeach
                    </tbody>
                </table>
  
                <div class="d-flex justify-content-between">
                    @if (count($this->formasPagoRestantes()) > 0)
                    <button wire:click="addFormaPago()" class="btn btn-xs btn-primary"><i class="fas fa-plus"></i> Pago con
                        varias formas</button>
                    @endif
                </div>
  
                <br>
                <center>
                    <?php
                      $pagosCount = count($formas_pago);
                      $montoTotal = 0;
                      foreach ($formas_pago as $elem) {
                          $elem['monto'] = is_numeric($elem['monto']) ? $elem['monto'] : 0; 
                          $montoTotal += $elem['monto'];
                      }
                      $cambio = $montoTotal - $this->paymentAmount;
                      $mensaje = 'Faltan';
                      if($pagosCount == 1){
                          $mensaje = $cambio > 0 ? 'Cambio':'Faltan';
                      }
                      else{
                          $mensaje = $cambio > 0 ? 'Sobran':'Faltan';
                      }
                    ?>
                    <h2>{{ $mensaje }} @money(abs($cambio))</h2>
                </center>
            </div>
  
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
              @php
                  if($pagosCount == 1){                
                      $disabled = $cambio < 0;
                      $color = $cambio < 0 ? 'danger' : 'success';
                      $txt = $cambio < 0 ? 'Saldo Pendiente' : 'PROCESAR PAGO';
                      $icon = $cambio < 0 ? 'fa-times-circle' : 'fa-dollar-sign';
                  } else {
                      $disabled = $cambio != 0;
                      $btnMensaje = $cambio > 0 ? 'Monto Excede' : 'Saldo Pendiente ';
                      $color = $cambio != 0 ? 'danger' : 'success';
                      $txt = $cambio != 0 ? $btnMensaje : 'PROCESAR PAGO';
                      $icon = $cambio != 0 ? 'fa-times-circle' : 'fa-dollar-sign';
                  }
              @endphp
              <button type="button" wire:click="pay()" class="btn btn-{{$color}}" @if($disabled) disabled @endif><i class="fas {{$icon}}"></i> {{$txt}}</button>
            </div>
        </div>
        
    </div>
</div>