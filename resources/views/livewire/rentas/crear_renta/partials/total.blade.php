<div class="card">
  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-cash-register"></i> Total de Renta</h3>

    <div class="card-tools">
      <button class="btn btn-xs btn-danger" wire:click="limpiarRenta()"><i class="fas fa-broom"></i> Limpiar Renta</button>
    </div>
  </div>

  <div class="card-body" style="min-height: 25vh">
    <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">
        <h3>Equipos</h3>
      </div>
      <div class="col-12 col-md-6">
        <h3>@qty($this->renta_t->totalProductos())</h3>
      </div>
    </div>

    <hr>

    <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">
        <h3>Total</h3>
      </div>
      <div class="col-12 col-md-6">
        <h3>@money($this->renta_t->total())</h3>
      </div>
    </div>

    @if ($this->renta_t->equipos->count() > 0 && $this->renta_t->cliente_id != 0)
      <hr>
      <div class="row layout-top-spacing">
        <div class="col-12">
          <button wire:click="selectText('.formaPago')" class="btn btn-large btn-block btn-success" data-toggle="modal" data-target="#mdlPagoCredito"><i class="fas fa-handshake"></i> CREAR RENTA</button>
        </div>
      </div>
    @endif

  </div>

</div>
