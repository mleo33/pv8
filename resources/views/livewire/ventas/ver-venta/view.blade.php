@section('title', __('Venta #' . $venta->id))
<div class="p-3">
  
  <div class="card">
    <div class="card-header d-flex p-0">
        <h3 class="pl-3 pt-3">Venta #@paddy($venta->id)</h3>
        <ul class="nav nav-pills ml-auto p-2">
          <li class="nav-item"><a class="nav-link {{ $activeTab == 1 ? 'active' : ''}}" wire:click="$set('activeTab',1)" href="#"><i class="fas fa-shopping-cart"></i> Venta</a></li>
          @if ($this->venta->cliente)
            <li class="nav-item"><a class="nav-link {{ $activeTab == 2 ? 'active' : ''}}" wire:click="$set('activeTab',2)" href="#"><i class="fas fa-user"></i> Cliente</a></li>
          @endif
          <li class="nav-item"><a class="nav-link {{ $activeTab == 3 ? 'active' : ''}}" wire:click="$set('activeTab',3)" href="#"><i class="fas fa-dollar-sign"></i> Pagos</a></li>
          <li class="nav-item"><a class="nav-link {{ $activeTab == 4 ? 'active' : ''}}" wire:click="$set('activeTab',4)" href="#"><i class="fas fa-file-alt"></i> Facturas</a></li>
          <li class="nav-item"><a class="nav-link {{ $activeTab == 5 ? 'active' : ''}}" wire:click="$set('activeTab',5)" href="#"><i class="fas fa-comments"></i> Comentarios</a></li>
        </ul>
    </div>
    
    <div class="card-body p-0">
        <div class="tab-content">
            
            <!-- /.tab-conceptos -->
            @include('livewire.ventas.ver-venta.tabs.tab1')

            <!-- /.tab-cliente -->
            @if ($this->venta->cliente)
              @include('livewire.ventas.ver-venta.tabs.tab2')
            @endif

            <!-- /.tab-pagos -->
            @include('livewire.ventas.ver-venta.tabs.tab3')

            <!-- /.tab-facturas -->
            @include('livewire.ventas.ver-venta.tabs.tab4')

            <!-- /.tab-comentarios -->
            @include('livewire.ventas.ver-venta.tabs.tab5')
        </div>
    </div>
  </div>

  @include('livewire.ventas.ver-venta.partials.modal_pago')
  @include('shared.ventas.modal_sale_details', ['venta' => $this->focusElement])
  @include('shared.general.modal_comentarios')

  {{-- @include('shared.general.modal_comentario_cancelacion', ['title' => 'Cancelar Contrato']) --}}
  
</div>



