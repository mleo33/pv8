<div class="card">
  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-cash-register"></i> Total de Cotización</h3>

    <div class="card-tools">
      <button class="btn btn-xs btn-danger" wire:click="limpiarCotizacion()"><i class="fas fa-broom"></i> Limpiar Cotización</button>
    </div>
  </div>

  <div class="card-body">

    <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">
        <h4>Subtotal</h4>
      </div>
      <div class="col-12 col-md-6">
        <h4>@money($this->cotizacion_t->subtotal)</h4><p class="m-0" style="font-size: 15px;">
      </div>
    </div>

    <hr>

    <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">

        <div class="row">
          <div class="col-5">
            <h4>IVA</h4>
          </div>

          <div class="col-7">
            <select wire:model="cotizacion_t.tasa_iva" class="form-control form-control-sm">
              <option value=0>N/A</option>
              <option value=8.00>8.00%</option>
              <option value=16.00>16.00%</option>
            </select>
          </div>

        </div>

      </div>
      <div class="col-12 col-md-6">
        <h4>@money($this->cotizacion_t->iva)</h4><p class="m-0" style="font-size: 15px;">
      </div>
    </div>

    <hr>

    <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">
        <h4>Total</h4>
      </div>
      <div class="col-12 col-md-6">
        <h4>@money($this->cotizacion_t->total)</h4><p class="m-0" style="font-size: 15px;">
      </div>
    </div>



    @if (collect($this->cotizacion_t->conceptos)->count() > 0)
      <hr>
      <div class="row layout-top-spacing">
        <div class="col-12">
          <button wire:click="mdlEnviarCotizacion" data-toggle="modal" data-target="#mdlPagoCredito" class="btn btn-large btn-block btn-success"><i class="fa fa-search-dollar"></i> CREAR COTIZACIÓN</button>
        </div>
      </div>
    @endif



  </div>

</div>
