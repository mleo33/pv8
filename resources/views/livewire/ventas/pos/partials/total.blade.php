<div class="card">
  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-cash-register"></i> Total de Venta</h3>

    <div class="card-tools">
      <button class="btn btn-xs {{$ventasGuardadas > 0 ? "btn-warning" : "btn-primary"}}" wire:click="guardarVenta"><i class="fas fa-save"></i> {{$ventasGuardadas > 0 ? "Ventas Guardadas({$ventasGuardadas})" : "Guardar Venta"}}</button>
      <button class="btn btn-xs btn-danger" wire:click="limpiarVenta"><i class="fas fa-broom"></i> Limpiar Venta</button>
    </div>
  </div>

  <div class="card-body">
    <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">
        <h3>Productos</h3>
      </div>
      <div class="col-12 col-md-6">
        <h3>@qty($this->venta_t->totalProductos())</h3>
      </div>
    </div>

    <hr>

    <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">
        <h3>Total</h3>
      </div>
      <div class="col-12 col-md-6">
        <h3>@money($this->venta_t->total())</h3>
      </div>
    </div>

    @if (collect($this->venta_t->registros)->count() > 0)
      <hr>
      <div class="row layout-top-spacing">
        <div class="col-5">
          <button data-toggle="modal" data-target="#mdlDescuento" class="btn btn-large btn-block btn-primary"><i class="fa fa-hand-holding-usd"></i> Descuento</button>
        </div>
        <div class="col-7">
          <button wire:click="mdlPago" data-toggle="modal" data-target="#mdlPagoCredito" class="btn btn-large btn-block btn-success"><i class="far fa-money-bill-alt"></i> PAGAR</button>
        </div>
      </div>
      
      <label class="mt-3" for="radioImprimirTicket">Imprimir Ticket</label>
      <input id="radioImprimirTicket" type="checkbox" wire:model.defer="printEtiqueta">

    @endif



  </div>

</div>
