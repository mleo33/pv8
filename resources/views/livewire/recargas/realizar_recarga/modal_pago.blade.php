<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlPago">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pagar @money($this->pagoRequerido)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                        @foreach ($formas_pago_venta as $key => $elem)

                        <tr>
                            <td>
                                @if (!$loop->first)
                                    <button wire:click="removeFormaPago({{ $loop->index }})" class='btn btn-danger btn-xs'>
                                        <i class="fas fa-minus"></i>
                                    </button>
                                @endif
                            </td>
                            <td>
                                <select wire:model='formas_pago_venta.{{ $key }}.forma' class="form-control" wire:change="changeFormaPago">
                                    <option wire:key="{{ $key . $elem['forma'] }}" value="{{  $elem['forma'] }}">{{  $elem['forma'] }}</option>
                                    @foreach ($formas_pago_restantes as $f)
                                    <option wire:key="{{ $key . $f }}" value="{{ $f }}">{{ $f }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input onclick="this.select()" style="text-align: right;" type="number" step="0.01" min="0.00" class="form-control formaPago"
                                wire:model='formas_pago_venta.{{ $loop->index }}.monto' autofocus />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-between">
                    {{-- @if (count($formas_pago_restantes) > 0)
                    <button wire:click="addFormaPago()" class="btn btn-xs btn-primary"><i class="fas fa-plus"></i> Pago con
                        varias formas</button>
                    @endif --}}
                </div>

                <br>
                <center>
                    <?php
                        $pagosCount = count($formas_pago_venta);
                        $montoTotal = 0;
                        foreach ($formas_pago_venta as $elem) {
                            $elem['monto'] = $elem['monto'] ? $elem['monto'] : 0; 
                            $montoTotal += $elem['monto'];
                        }
                        $cambio = $montoTotal - $this->pagoRequerido;
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
                <div wire:loading.remove wire:target="pagar">
                    <button type="button" wire:click="pagar" class="btn btn-{{$color}}" @if($disabled) disabled @endif><i class="fas {{$icon}}"></i> {{$txt}}</button>
                </div>
                <div wire:loading wire:target="pagar">
                    <button type="button" class="btn btn-info"><i class="fas fa-spinner fa-spin"></i> Procesando...</button>
                </div>
            </div>
        </div>
    </div>
</div>

  
                


