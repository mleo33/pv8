<div class="card">
  <div class="card-header">
    <h2 class="card-title font-weight-bold"><i class="fa fa-file-alt"></i> Cotizar @if ($this->cotizacion_t->cantidad_conceptos > 0)
        ({{$this->cotizacion_t->cantidad_conceptos}})
    @endif Productos</h2>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
        <button wire:click="$emit('showModal','#mdlSelectProducto')" class="btn btn-sm btn-primary"><i class="fas fa-barcode"></i> Productos</button>
      </button>
    </div>
  </div>
  <div class="card-body p-0" style="min-height: 85vh">
    <table class="table table-hover">
      <thead>
        <tr>
          <th></th>
          <th>Código</th>
          <th>Descripción</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Sub-Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($cotizacion_t->conceptos ?? [] as $item)
          <tr>
            <td><button onclick="destroy('{{ $item->id }}','{{ $item->descripcion }}')"
                class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button></td>
            <td>{{ $item->codigo }}</td>
            <td>{{ $item->descripcion }}</td>
            <td>
              <button wire:click="addQty({{ $item->id }},-1)" class="btn btn-warning btn-xs">
                <i class="fas fa-minus"></i>
              </button>
              <button wire:click="mdlChangeQty({{ $item->id }})"
                class="btn btn-default btn-xs">
                <b class="m-3">{{ $item->cantidad }}</b>
              </button>
              <button wire:click="addQty({{ $item->id }},1)" class="btn btn-warning btn-xs">
                <i class="fas fa-plus"></i>
              </button>
            </td>
            <td>
              <input style="width: 100px; text-align: right;" wire:model.lazy="cotizacion_t.conceptos.{{$loop->index}}.precio" wire:change="priceChange({{$loop->index}})" onclick="this.select()" onkeypress="return event.charCode >= 46 && event.charCode <= 57"  type="text" class="form-control form-control-sm"/>
            </td>
            <td>@money($item->importe)</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
