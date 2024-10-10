@section('title', __('Rentas'))
<div class="p-3">

  <div class="row layout-top-spacing">

    {{-- <div class="col">
        <!--COMENTARIOS-->
        @include('livewire.rentas.crear_renta.partials.comentarios')
    </div> --}}

    <div class="col-8">
      <!--CLIENTE-->
      @include('shared.clientes.card-cliente', [
        'cliente' => $this->renta_t->cliente,
        'entidad_fiscal' => $this->renta_t->entidad_fiscal,
        'showFechaRenta' => true,
      ])
    </div>

    <div class="col-4">
        <!--TOTAL PANEL -->
        @include('livewire.rentas.crear_renta.partials.total')
    </div>

  </div>


  <div class="row layout-top-spacing">

    <div class="col">
      @include('livewire.rentas.crear_renta.partials.tabla')
    </div>
    
  </div>





  @if ($this->renta_t->cliente)
    @include('livewire.rentas.crear_renta.partials.modal_pago_credito')
    @include('livewire.rentas.crear_renta.partials.modal_pago')
    @include('shared.rentas.modal_active_rents', ['cliente' => $this->renta_t->cliente])
  @endif
  @if(isset($this->registro_t->id))
    @include('shared.equipos.modal_unidades')
    @include('shared.equipos.modal_horometro')
  @endif
  @include('livewire.rentas.crear_renta.partials.modal_precios_renta')
  @include('shared.clientes.modal-selection')
  @include('shared.clientes.modal-entidades-fiscales', ['cliente' => $this->renta_t->cliente])
  @include('shared.equipos.modal-selection')
  @include('shared.traslados.modal-selection')
  
</div>



