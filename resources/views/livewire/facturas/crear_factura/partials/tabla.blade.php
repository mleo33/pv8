<div class="card">
  <div class="card-header">
    <h2 class="card-title font-weight-bold"><i class="fas fa-file-alt"></i> Conceptos de Facturación</h2>
    <div class="card-tools">
      @if ($this->factura_t->model_id)
        @php
            $model = $this->factura_t->model_type == 'App\\Models\\Venta' ? 'Venta' : '';
            $model = $this->factura_t->model_type == 'App\\Models\\Renta' ? 'Renta' : $model;
        @endphp
        <button class="btn btn-sm btn-danger" wire:click="removeModel"><i class="fas fa-times"></i> Remover {{$model}}</button>    
      @endif
      <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#mdlConcepto"><i class="fas fa-cube"></i> Agregar Concepto</button>
      <button class="btn btn-sm btn-success" wire:click="$emit('initMdlSelectProducto')"><i class="fas fa-barcode"></i> Agregar Producto</button>
      {{-- <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#mdlSelectProduct"><i class="fas fa-barcode"></i> Agregar Producto</button> --}}
      {{-- <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#mdlSelectEquipment"><i class="fas fa-caravan"></i> Agregar Equipo</button> --}}
      {{-- <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#mdlSelectRoute"><i class="fas fa-route"></i> Agregar Traslado</button> --}}
    </div>
  </div>
  <div class="card-body p-0" style="min-height: 50vh">
    <table class="table table-hover">
      <thead>
        <tr>
          <th></th>
          <th>#</th>
          <th>Identificador</th>
          <th style="width: 40%">Descripción</th>
          <th>Clave Producto</th>
          <th>Clave Unidad</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Sub-Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($this->factura_t->conceptos as $indx => $elem)
          <tr>
            <td><button type="button" wire:click="removeConcepto({{$indx}})" class="btn btn-xs btn-danger"><i class='fa fa-times'></i></button></td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $elem->no_identificacion }}</td>
            <td><textarea wire:change="saveConcepto({{$indx}})" style="resize: none;" rows="1" class="form-control" wire:model="factura_t.conceptos.{{$indx}}.descripcion"></textarea></td>
            <td><button wire:click="mdlClaveProductos({{$elem->id}})" class="btn btn-primary btn-sm pl-3 pr-3"><b>{{ $elem->clave_prod_serv }}</b></button></td>
            <td><button wire:click="mdlClaveUnidades({{$elem->id}})" class="btn btn-primary btn-sm pl-3 pr-3"><b>{{ $elem->clave_unidad }}</b></button></td>
            {{-- <td>{{ $elem->cantidad }}</td> --}}
            {{-- <td>@money($elem->valor_unitario)</td> --}}
            <td><input wire:model.lazy="factura_t.conceptos.{{$indx}}.cantidad" wire:change="saveConcepto({{$indx}})" style="text-align: center" min="1" type="number" class="form-control"/></td>
            <td><input wire:model.lazy="factura_t.conceptos.{{$indx}}.valor_unitario" wire:change="saveConcepto({{$indx}})" style="text-align: right" min="1" type="number" class="form-control"/></td>
            <td>@money($elem->sub_importe())</td>
          </tr>
        @endforeach
      </tbody>
    </table>


  </div>
</div>