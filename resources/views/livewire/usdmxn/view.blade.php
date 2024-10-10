<div class="pt-4">

  <div class="row justify-content-center">
    <div class="col-md-auto">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">USDMXN</h3>
        </div>  
        <div class="card-body p-0">
               
          <div class="row m-2">
            <div class="col">
              <label>Cotización</label>
              <input wire:model="usd.cotizacion" min="1.0" type="number" class="form-control">
              Modificado por {{$this->usd->modificado_por->name}}<br>
              ({{$this->usd->updated_at_format()}})<br>
              @error('usd.cotizacion') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="row m-2 mt-4">
            <div class="col">
              <button wire:click="guardarUSD" class="btn btn-large btn-block btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
          </div>
          
          
          <br>
          
        </div>
    </div>
    </div>
  </div>


</div>
