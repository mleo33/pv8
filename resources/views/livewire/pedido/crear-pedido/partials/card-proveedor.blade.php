<div class="card">
  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-user-friends"></i> Proveedor</h3>
    <div class="card-tools">
      @if($pedido_t->proveedor)
        <button class="btn btn-xs btn-danger" wire:click="setProveedor(0)"><i class="fas fa-minus"></i> <i class="fas fa-user"></i> Remover Proveedor</button>
      @else
        <button class="btn btn-xs btn-primary" wire:click="$emit('showModal', '#mdlSelectProveedor')"><i class="fas fa-plus"></i><i class="fas fa-user"></i> Agregar Proveedor</button>
      @endif
    </div>
  </div>


  <div class="card-body p-3">
    @if(isset($pedido_t->proveedor))
      <p><b>Nombre: </b>{{ $pedido_t->proveedor->nombre }}<br>
      @if($pedido_t->proveedor->rfc)
        <b>RFC: </b>{{ $pedido_t->proveedor->rfc }}<br>
      @endif
      @if($pedido_t->proveedor->correo)
        <b>Correo: </b>{{ $pedido_t->proveedor->correo }}</p>
      @endif
      
    @else
      <center>
        <h4>Seleccione Proveedor</h4>
      </center>
    @endif
    
  </div>
</div>
  