@section('title', __('Cotizaciones'))
<div class="pt-3">

  <div class="row layout-top-spacing">
    <div class="col-12 col-md-8">

      @include('livewire.cotizacion.crear-cotizacion.partials.tabla-productos')

    </div>
    <div class="col-12 col-md-4">
      <div class="sticky-top">
        <!--TOTAL PANEL -->
        @include('livewire.cotizacion.crear-cotizacion.partials.card-total')

        <!--CLIENTE-->
        @include('livewire.cotizacion.crear-cotizacion.partials.card-cliente')

        <!--PRODUCTO-->
        {{-- @include('livewire.ventas.pos.partials.productos') --}}

        <!--COMENTARIOS-->
        @include('livewire.cotizacion.crear-cotizacion.partials.card-comentarios')
      </div>
    </div>      
    
  </div>
    
  @include('livewire.cotizacion.crear-cotizacion.partials.mdl-enviar-cotizacion')
  
  <livewire:cliente.common.mdl-select-cliente emitAction="setCliente" />
  <livewire:producto.common.mdl-select-producto emitAction="addProducto" priceField='precio' checkStock={{false}} />
  <livewire:producto.common.mdl-select-qty emitAction="changeQty" />
</div>



