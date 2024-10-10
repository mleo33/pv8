<div class="card-body" style="min-height: 25vh">


  <div class="row layout-top-spacing">
    <div class="col-12 col-md-6">
      <h4>Subtotal</h4>
    </div>
    <div class="col-12 col-md-6">
      <h3 class="m-0">@money($this->factura_t->subtotal) </h3>
    </div>
  </div>


  <hr>


  <div class="row layout-top-spacing">
    <div class="col-12 col-md-6">
      <h4>IVA</h4>
    </div>
    <div class="col-12 col-md-6">
      <h3 class="m-0">@money($this->factura_t->iva()) </h3><p class="m-0" style="font-size: 15px;">IVA @php echo number_format($factura_t->tasa_iva, 2) @endphp%</p>
    </div>
  </div>


  <hr>


  <div class="row layout-top-spacing">
    <div class="col-12 col-md-6">
      <h4>Total</h4>
    </div>
    <div class="col-12 col-md-6">
      <h3 class="m-0">@money($this->factura_t->total_c_iva) </h3>
    </div>
  </div>



  {{-- @if ($this->factura_t->conceptos->count() > 0 && $this->cliente) --}}
  @if (!$this->factura_t->sucursal->emisor)
    <hr>
    <div class="row layout-top-spacing">
      <div class="col-12">
        <button wire:click="" disabled class="btn btn-large btn-block btn-danger"><i class="fas fa-university"></i> Sucursal no cuenta con emisor fiscal</button> 
      </div>
    </div>
  @endif
  
  @if($this->factura_t->cliente && $this->factura_t->entidad_fiscal && $this->factura_t->conceptos && $this->factura_t->conceptos->count() > 0 && $this->factura_t->sucursal->emisor)
    <hr>
    <div class="row layout-top-spacing">
      <div class="col-12">
        <button wire:click="confirm" class="btn btn-large btn-block btn-success"><i class="fas fa-file-alt"></i> Generar Factura</button>
      </div>
    </div>
  @endif

</div>