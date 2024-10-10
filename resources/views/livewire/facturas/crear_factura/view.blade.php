@section('title', __('Crear Factura'))
<div class="p-3">

  <div class="row layout-top-spacing">

    {{-- <div class="col">
        <!--COMENTARIOS-->
        @include('livewire.rentas.crear_renta.partials.comentarios')
    </div> --}}

    <div class="col">
      <!--CLIENTE-->

      @include('shared.clientes.card-cliente', [
        'cliente' => $this->factura_t->cliente, 
        'entidad_fiscal' => $this->factura_t->entidad_fiscal,
        'showEntidadesFiscales' => true,
        'showFacturacionControl' => true,
        'showRentasActivas' => false])
    </div>

    {{-- <div class="col-4">
      <!--TOTAL PANEL -->
      @include('livewire.facturas.crear_factura.partials.total')
    </div> --}}



  </div>


  <div class="row layout-top-spacing">

    <div class="col">
      @include('livewire.facturas.crear_factura.partials.tabla')
    </div>
    
  </div>

  
  @include('shared.ventas.modal_selection')
  @include('shared.general.modal_concepto')
  @include('shared.facturacion.modal_clave_productos', ['claveCreateMode' => $this->claveCreateMode])
  @include('shared.facturacion.modal_clave_unidades')
  @include('shared.clientes.modal-entidades-fiscales', ['cliente' => $this->factura_t->cliente])
  @include('livewire.facturas.crear_factura.modals.mdl-confirm')

  
</div>

