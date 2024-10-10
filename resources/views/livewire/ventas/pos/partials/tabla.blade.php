<div class="card">
  <div class="card-header">
    <h2 class="card-title font-weight-bold"><i class="fas fa-shopping-cart"></i> Tabla de Venta</h2>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" >
        <input wire:model="inputProduct" wire:keydown.enter="buscarInputProduct" type="text" class="form-control" />
        <button wire:click="$emit('initMdlSelectProducto')" class="btn btn-sm btn-primary"><i class="fas fa-barcode"></i> Productos</button>
      </button>
    </div>
  </div>
  <div class="card-body p-0" style="min-height: 85vh">
    <table class="table table-hover">
      <thead>
        <tr>
          <th></th>
          <th>#</th>
          <th>Código</th>
          <th>Descripción</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Sub-Total</th>
          <th>Desc.</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($venta_t->registros ?? [] as $item)
          <tr>
            <td><button onclick="destroy('{{ $item->id }}','{{ $item->descripcion }}')"
                class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button></td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->codigo }}</td>
            <td>{{ $item->descripcion }}</td>
            <td>
              <button wire:click="addQty({{ $item->id }},-1)" class="btn btn-warning btn-xs">
                <i class="fas fa-minus"></i>
              </button>
              <button onclick="changeQty('{{ $item->id }}', '{{ $item->descripcion }}', {{ $item->cantidad }})"
                class="btn btn-default btn-xs">
                <b class="m-3">{{ $item->cantidad }}</b>
              </button>
              <button wire:click="addQty({{ $item->id }},1)" class="btn btn-warning btn-xs">
                <i class="fas fa-plus"></i>
              </button>
            </td>
            <td width="15%">
              @can('cambiar-precio-venta')
                <input style="text-align: right" onclick="select()" onkeypress="return event.charCode >= 46 && event.charCode <= 57" wire:model.debounces.1s="venta_t.registros.{{$loop->index}}.precio" class="form-control" type="text" />
              @else
                @money($item->precio_con_descuento)
              @endif
            </td>
            <td>@money($item->importe())</td>
            <td>
              @if ($item->descuento > 0)
                <button wire:click="mdlDescuento({{ $item->id }})" class="btn btn-primary btn-xs"><i class="fas fa-hand-holding-usd"></i> {{$item->descuento}}%</button>
              @else
                <button wire:click="mdlDescuento({{ $item->id }})" class="btn btn-default btn-xs"><i class="fas fa-hand-holding-usd"></i></button>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
