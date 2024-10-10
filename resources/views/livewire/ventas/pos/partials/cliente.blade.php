<div class="card">
  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-user"></i> Cliente</h3>
    <div class="card-tools">
      @if($venta_t->cliente)
        <button class="btn btn-xs btn-danger" wire:click="setClient(0)"><i class="fas fa-minus"></i> <i class="fas fa-user"></i> Remover Cliente</button>
      @else
        <button class="btn btn-xs btn-primary" wire:click="$emit('showModal','#mdlSelectClient')"><i class="fas fa-plus"></i><i class="fas fa-user"></i> Agregar Cliente</button>
      @endif
    </div>
  </div>


  <div class="card-body p-3">
    
    @if(isset($venta_t->cliente))
      <h5><b>Nombre: </b>{{ $venta_t->cliente->nombre }}</h5>
      @if($venta_t->cliente->rfc)
        <h5><b>RFC: </b>{{ $venta_t->cliente->rfc }}</h5>
      @endif
      @if($venta_t->cliente->correo)
        <h5><b>Correo: </b>{{ $venta_t->cliente->correo }}</h5>
      @endif
      @if($venta_t->cliente->correo)
        <h5><b>Crédito Disponible: </b>@money($venta_t->cliente->credito_disponible())</h5>
      @endif

      <h5><b>Puntos Disponibles: </b>{{$venta_t->cliente->puntos}}</h5>
      @if ($venta_t->total() > 0)            
        <center>
          @if($venta_t->cliente->puntos >= $venta_t->total())
            <button wire:click="pagarConPuntos" class="btn btn-success btn-xs"><i class="fa fa-gift"></i> PAGAR CON PUNTOS</button>
          @else
            <button wire:click="pagarConPuntos" class="btn btn-danger btn-xs" disabled><i class="fa fa-times"></i> Faltan {{(ceil($venta_t->total()) - $venta_t->cliente->puntos) }} puntos</button>
          @endif
          <button onclick="mdlDiasApartado()" class="btn btn-primary btn-xs"><i class="fa fa-clock"></i> Apartar Articulos</button>
        </center>
      @endif
      
    @else
      <center>
        <h4>Venta al público en general</h4>
      </center>
    @endif
    
  </div>
</div>
  