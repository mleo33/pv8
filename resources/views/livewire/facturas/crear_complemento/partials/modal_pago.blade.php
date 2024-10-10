<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Complemento de pago - Factura {{$factura->serie}}{{$factura->folio}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>

          <div class="modal-body">
            <div class="form-row">
                <div class="form-group col-md-8">
                    <div class="form-group">
                        <label for="FechaPago">Fecha de Pago</label>
                        <input wire:model="FechaPago" type="date" class="form-control"/>
                        @error('FechaPago') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
    
                <div class="form-group col-md-4">
                    <div class="form-group">
                        <label for="Monto">Monto</label>
                        <input wire:model="Monto" style="text-align: right;" type="number" class="form-control"/>
                        @error('Monto') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="FormaDePagoP">Forma de Pago</label>
                        <select wire:model="FormaDePagoP" class="form-control">
                            <option value=""></option>
                            @foreach ($formas_pago as $i => $elem)
                                @if ($i != "99")
                                    <option value="{{$i}}">{{$elem}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('FormaDePagoP') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
    
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="NumOperacion">No. de Operación</label>
                        <input type="text" wire:model="NumOperacion" class="form-control"/>
                        @error('NumOperacion') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-6">
                    <h3>Importe Pagado: @money($ImpPagado)</h3>
                </div>

                <div class="form-group col-md-6">
                    <h3>Saldo: @money($ImpSaldoAnt)</h3>
                </div>
    
            </div>

            <div class="form-row">
                <div class="form-group col-md-7">
                    <div class="form-group">
                        <label for="RfcEmisorCtaOrd">RFC Cuenta Origen</label>
                        <input wire:model="RfcEmisorCtaOrd" type="text" style="text-transform: uppercase" class="form-control"/>
                        @error('RfcEmisorCtaOrd') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
    
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="CtaOrdenante">Cuenta</label>
                        <input wire:model="CtaOrdenante" type="text" class="form-control"/>
                        @error('CtaOrdenante') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-7">
                    <div class="form-group">
                        <label for="RfcEmisorCtaBen">RFC Cuenta Beneficiaria</label>
                        <input wire:model="RfcEmisorCtaBen" type="text" style="text-transform: uppercase" class="form-control"/>
                        @error('RfcEmisorCtaBen') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
    
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="CtaBeneficiario">Cuenta</label>
                        <input wire:model="CtaBeneficiario" type="text" class="form-control"/>
                        @error('CtaBeneficiario') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>

            @if ($this->factura->sucursal->emisor)
                <button type="button" wire:click="generarComplemento()" class="btn btn-primary"><i class="fas fa-check"></i> Crear Complemento</button>
            @else
                <button type="button" wire:click="" class="btn btn-danger" disabled><i class="fas fa-university"></i> Sucursal no cuenta con emisor fiscal</button>
            @endif

          </div>
      </div>
  </div>
</div>
