@section('title', __('Complementos de pago'))
<div class="p-3">

  <div class="row layout-top-spacing">

    <div class="col">
      @include('livewire.facturas.crear_complemento.partials.factura_card')
    </div>

  </div>


  <div class="row layout-top-spacing">

    <div class="col">
      @include('livewire.facturas.crear_complemento.partials.tabla_complementos')
    </div>
    
  </div>
  
  @include('livewire.facturas.crear_complemento.partials.modal_pago')
  @if ($this->factura->id)
    @include('shared.facturacion.modal_enviar_factura')
  @endif
</div>


