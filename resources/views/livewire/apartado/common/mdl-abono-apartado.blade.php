<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Anticipo de apartado:</h5>
                <button type="button" class="close" data-toggle="modal" data-target="#{{$this->mdlName}}" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center>

                    <h2>Monto Total: @money($this->apartado->importe ?? 0)</h2>
                    <h2>Pagado: @money($this->apartado?->pagado)</h2>
                    <h2>Pendiente: @money($this->apartado?->saldo)</h2>
    
                    <br>
                    <div class="form-group">
                        <label>Monto a Pagar</label>
                        <input wire:keydown.enter="pay" wire:model="montoAPagar" style="width: 50%; text-align: center" type="text" onClick="this.select();" onkeypress="return event.charCode >= 46 && event.charCode <= 57" class="form-control form-control-lg" />
                        @error('montoAPagar') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <h4>Saldo Pendiente: @money($this->saldoPendiente())</h4>

                </center>
            </div>
  
            <div class="modal-footer justify-content-between">
                <button data-toggle="modal" class="btn btn-secondary" data-target="#{{$this->mdlName}}"><i class="fas fa-window-close"></i> Cancelar</button>
                <button wire:click="pay" class="btn btn-success"><i class="fas fa-cash-register"></i> Pagar</button>
            </div>
        </div>
        
    </div>
</div>