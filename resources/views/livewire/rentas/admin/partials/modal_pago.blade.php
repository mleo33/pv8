<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlPago">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title">Pago Renta #@paddy($this->renta->id)</h4>
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
                    <th>Pagado</th>
                    <th>Saldo Pendiente</th>
                    <th width="15%">Pagar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->renta->registros as $key => $elem)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$elem->descripcion}}</td>
                        <td>{{$elem->model->propietario ?? 'N/A'}}</td>
                        <td>@money($elem->importe())</td>
                        <td>@money($elem->pagado)</td>
                        <td>@money($elem->saldo_pendiente())</td>
                        <td>
                            <input {{--wire:change="saveRegistro({{$key}})"--}} style="text-align: right;" type="number" step="0.01" min="0.00" class="form-control formaPago"
                            wire:model='renta.registros.{{ $loop->index }}.a_pagar'/>
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
                // $montoRenta = $this->renta->total();
                $pagoTotal = $this->renta->registros->sum('a_pagar');
                
                // $pendiente = $pagoTotal - $montoRenta;
                $pendiente = $this->renta->saldo_pendiente();
                $mensaje = $pendiente < 0 ? 'A favor:' : 'Pendiente:';
                ?>
                <label>Forma de Pago</label>
                <select style="width: 30%" class="form-control" wire:model='pago.forma_pago'>
                    <option value="EFECTIVO">EFECTIVO</option>
                    <option value="CHEQUE">CHEQUE</option>
                    <option value="TARJETA DEBITO">TARJETA DEBITO</option>
                    <option value="TARJETA CREDITO">TARJETA CREDITO</option>
                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                </select>
                @if ($this->pago->forma_pago != "EFECTIVO")
                    <label>Referencia / Voucher</label>
                    <input style="width: 40%; text-align: center" type="text" class="form-control" wire:model="pago.referencia" />
                @endif
                <br>

                <h2>Pagar: @money($pagoTotal)</h2>
                <h3>{{ $mensaje }} @money(abs($pendiente))</h3>




            </center>
        </div>

        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
            @php
                $color = $pagoTotal > 0 ? 'success' : 'danger';
                $txt = $pagoTotal > 0 ? 'PROCESAR PAGO' : 'Ingrese Monto';
                $icon = $pagoTotal > 0 ? 'fa-dollar-sign' : 'fa-times-circle';
            @endphp
            <button type="button" wire:click="registrarPago()" class="btn btn-{{$color}}" @if($pagoTotal <= 0) disabled @endif><i class="fas {{$icon}}"></i> {{$txt}}</button>
        </div>

      </div>
  </div>
</div>
