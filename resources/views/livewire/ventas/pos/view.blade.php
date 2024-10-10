@section('title', __('Ventas'))
<div class="p-3">

  <div class="row layout-top-spacing">
    <div class="col-12 col-md-8">

      @include('livewire.ventas.pos.partials.tabla')

    </div>
    <div class="col-12 col-md-4">
      <div class="sticky-top">
        <!--TOTAL PANEL -->
        @include('livewire.ventas.pos.partials.total')

        <!--CLIENTE-->
        @include('livewire.ventas.pos.partials.cliente')

        <!--PRODUCTO-->
        {{-- @include('livewire.ventas.pos.partials.productos') --}}

        <!--COMENTARIOS-->
        @include('livewire.ventas.pos.partials.comentarios')
      </div>
    </div>      
    
  </div>
    
  @include('livewire.ventas.pos.partials.modal_pago')
  @if ($this->venta_t->cliente)  
    @include('livewire.ventas.pos.partials.modal_pago_credito')
  @endif
  @include('shared.clientes.modal-selection')
  {{-- @include('shared.productos.modal-selection') --}}
  <livewire:producto.common.mdl-select-producto successAction="addProducto" priceField='precio' stockValidation={{true}} />
  @include('livewire.ventas.pos.partials.modal_descuento')
  @include('livewire.ventas.pos.partials.modal_descuento_registro')
  @include('livewire.ventas.pos.partials.modal_ventas_guardadas')

  <livewire:ingreso.common.mdl-cash-payment />
  <livewire:apartado.common.mdl-anticipo-apartado />
</div>



