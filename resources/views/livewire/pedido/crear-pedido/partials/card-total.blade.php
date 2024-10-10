<div class="card">
  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-cash-register"></i> Total de Pedido</h3>

    <div class="card-tools">
      <button class="btn btn-xs btn-danger" wire:click="limpiarPedido()"><i class="fas fa-broom"></i> Limpiar Pedido</button>
    </div>
  </div>

  <div class="card-body">
    <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">
        <h4>Productos</h4>
      </div>
      <div class="col-12 col-md-6">
        <h4>@qty($this->pedido_t->total_productos)</h4>
      </div>
    </div>

    <hr>

    <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">
        <h3>Total</h3>
      </div>
      <div class="col-12 col-md-6">
        <h3>@money($this->pedido_t->total)</h3><p class="m-0" style="font-size: 15px;">
          {{-- IVA @php echo number_format($pedido_t->tasa_iva, 2) @endphp%</p> --}}
      </div>
    </div>

    {{-- <hr>

    <div class="row layout-top-spacing">
      <div class="col-12 col-md-6">
        <h4>IVA</h4>
      </div>
      <div class="col-12 col-md-6">
        <h4>@money($this->pedido->importe)</h4>
      </div>
    </div> --}}

    @if (collect($this->pedido_t->conceptos)->count() > 0 && $this->pedido_t->proveedor)
      <hr>
      <div class="row layout-top-spacing">
        <div class="col-12">
          <button wire:click="mdlEnviarPedido" data-toggle="modal" data-target="#mdlPagoCredito" class="btn btn-large btn-block btn-success"><i class="fa fa-truck"></i> REALIZAR PEDIDO</button>
        </div>
      </div>
    @endif



  </div>

</div>
