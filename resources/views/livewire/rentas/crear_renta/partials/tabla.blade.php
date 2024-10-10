<div class="card">
  <div class="card-header">
    <h2 class="card-title font-weight-bold"><i class="fas fa-caravan"></i> Equipos para Renta</h2>
    <div class="card-tools">
      <div class="card-tools">
        <button class="btn btn-sm btn-primary" wire:click="mdlSelectRoute()"><i class="fas fa-route"></i> Agregar Traslado</button>
        <button class="btn btn-sm btn-warning" wire:click="mdlSelectEquipment()"><i class="fas fa-caravan"></i> Agregar Equipo</button>
      </div>
    </div>
  </div>
  <div class="card-body p-0" style="min-height: 50vh">
    <table class="table table-hover projects">
      <thead>
        <tr>
          <th></th>
          <th>#</th>
          <th>FUA</th>
          <th></th>
          <th></th>
          <th style="width: 30%">Descripción</th>
          <th>Renta</th>
          <th>Precio</th>
          <th>Retorno</th>
          <th>Sub-Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($this->renta_t->equipos as $item)
          <tr>
            <td><button onclick="destroy('{{ $item->id }}','{{ $item->model->descripcion }}')"
                class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button></td>
            <td>{{ $loop->iteration }}</td>
            <td><button class="btn btn-warning btn-xs pl-3 pr-3"><b>{{ $item->model->fua }}</b></button></td>
            <td>
              @if ($item->model->cantidad > 1)
                <button wire:click="mdlUnidades({{$item->id}})" class="btn btn-success btn-xs"> X {{$item->unidades}} </button>    
              @endif
            </td>
            <td>
              @if ($item->horometro_inicio)
                <button wire:click="mdlHorometro({{$item->id}})" class="btn btn-info btn-xs"><i class="fas fa-tachometer-alt"></i></button>    
              @endif
            </td>
            
            <td>{{ $item->model->descripcion }}</td>
            <td>
              <button wire:click="addQty({{ $item->id }},-1)" class="btn btn-warning btn-xs">
                <i class="fas fa-minus"></i>
              </button>
              <button style="width: 60%" wire:click="mdlPrecioRentas({{$item->model_id}},{{$item->id}})" class="btn btn-default btn-xs"><b class="m-3">
                {{ $item->cantidad }} {{$item->tipo_renta }}{{ $item->cantidad > 1 ? ($item->tipo_renta == 'MES' ? 'ES' : 'S') : '' }}</b>
              </button>
              <button wire:click="addQty({{ $item->id }},1)" class="btn btn-warning btn-xs">
                <i class="fas fa-plus"></i>
              </button>
            </td>
            <td>@money($item->precio)</td>
            <td>{{ $item->retorno_format() }}</td>
            <td>@money($item->importe())</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    @if ($this->renta_t->traslados()->count() > 0)
      <h3 class="ml-4 mt-4">Traslados</h3>
      <table class="table table-hover projects">
        <thead>
          <tr>
            <th></th>
            <th>Destino</th>
            <th>Viaje</th>
            <th>Costo</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($renta_t->traslados() as $item)
            <tr>
              <td><button onclick="destroy('{{ $item->id }}','traslado a {{ $item->model->destino }}')"
                  class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button></td>
              <td>{{ $item->model->destino }}</td>
              <td>{{ $item->tipo_renta }}</td>
              <td>@money($item->precio)</td>
            </tr>
          @endforeach
        </tbody>
      </table>
        
    @endif


  </div>
</div>
