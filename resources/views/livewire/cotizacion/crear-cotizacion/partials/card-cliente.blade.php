<div class="card">
  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-user-friends"></i> Cliente</h3>
    <div class="card-tools">
      @if($cotizacion_t->cliente)
        <button class="btn btn-xs btn-danger" wire:click="setCliente(0)"><i class="fas fa-minus"></i> <i class="fas fa-user"></i> Remover Cliente</button>
      @else
        <button class="btn btn-xs btn-primary" wire:click="$emit('showModal', '#mdlSelectCliente')"><i class="fas fa-plus"></i><i class="fas fa-user"></i> Agregar Cliente</button>
      @endif
    </div>
  </div>


  <div class="card-body p-3">
    @if(isset($cotizacion_t->cliente))
      <p><b>Nombre: </b>{{ $cotizacion_t->cliente->nombre }}<br>
      @if($cotizacion_t->cliente->rfc)
        <b>RFC: </b>{{ $cotizacion_t->cliente->rfc }}<br>
      @endif
      @if($cotizacion_t->cliente->correo)
        <b>Correo: </b>{{ $cotizacion_t->cliente->correo }}</p>
      @endif
      
    @else
      <center>
        <h4>Seleccione Cliente</h4>
      </center>
    @endif
    
  </div>
</div>
  