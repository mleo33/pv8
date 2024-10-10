<div class="card">
  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-user"></i> Cliente</h3>      
  </div>
  
  <div class="card-body p-3" style="min-height: 25vh">
    
    @if(isset($renta_t->cliente))
      <button class="btn btn-xs btn-danger mb-2" wire:click="setClient(0)"><i class="fas fa-minus"></i> <i class="fas fa-user"></i> Remover Cliente</button>
      <br>
      <h6><b>Nombre: </b>{{ $renta_t->cliente->nombre }}</h6>
      <h6><b>Dirección: </b>{{ $renta_t->cliente->direccion }}</h6>
      @if($renta_t->cliente->correo)
        <h6><b>Correo: </b>{{ $renta_t->cliente->correo }}</h6>
      @endif

      @if(isset($renta_t->entidad_fiscal))
        <h6><b>Razón Social: </b>{{ $renta_t->entidad_fiscal->razon_social }}</h6>
        <h6><b>RFC: </b>{{ $renta_t->entidad_fiscal->rfc }}</h6>
      @endif
      
      @if ($renta_t->cliente->entidades_fiscales->count() > 1)
        <button wire:click='mdlEntidadesFiscales' class="btn btn-xs btn-primary"><i class="fa fa-university"></i> Seleccionar RFC</button>
      @endif

      @if ($renta_t->cliente->rentas_activas->count() > 0)
        <button data-toggle="modal" data-target="#mdlActiveRents" class="btn btn-warning btn-xs"><i class="fas fa-clock"></i> Rentas Activas ({{$renta_t->cliente->rentas_activas->count()}})</button>
      @endif
      
      
      
      
    @else
      <button class="btn btn-sm btn-primary" wire:click="$emit('showModal','#mdlSelectClient')"><i class="fas fa-plus"></i><i class="fas fa-user"></i> Agregar Cliente</button>
    @endif
    
  </div>
</div>
  