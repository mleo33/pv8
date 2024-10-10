<div class="pt-4">

    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Ventas Realizadas</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">

          <div class="row m-2">
            <div class="col-md-6">
              <label>Inicio</label>
              <input type="date" class="form-control" wire:model.lazy="startDate">
            </div>

            <div class="col-md-6">
              <label>Final:</label>
              <input type="date" class="form-control" wire:model.lazy="endDate">
            </div>
          </div>
          
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Vendedor</th>
                <th>Cliente</th>
                <th>Productos</th>
                <th>Monto</th>
                <th>Ver venta</th>
                <th>Cancelar</th>
              </tr>
            </thead>
            <tbody>
              @foreach($ventas as $item)
                <tr>
                  <td><a class="btn btn-default" href="aosprint:ticket_venta#{{$item->id}}"> @paddy($item->id) </a></td>
				          <td>{{ $item->created_at->format('m/d/Y h:i A') }}</td>
                  <td>{{ $item->usuario->name }}</td>
                  <td>{{ $item->cliente->nombre ?? 'NO IDENTIFICADO' }}</td>
                  <td><button wire:click="viewRegistros({{$item->id}})" class="btn btn-sm btn-primary"><i class="fas fa-shopping-basket"></i> <b>{{ $item->totalProductos() }}</b></button></td>
                  <td>@money($item->total())</td>

                  @if ($item->is_canceled)
                    <td>CANCELADA</td>
                    <td style="color: red;">
                      <p style=" margin: 0px;">Cancelado por: {{$item->user_cancel->name}}</p>
                      <small>{{$item->canceled_at_format}}</small>
                    </td>
                  @else
                    <td>
                      <a href="venta/{{$item->id}}" class="btn btn-sm btn-primary" ><i class="fas fa-shopping-cart"></i> Ver Venta</a>
                    </td>
                    <td><button wire:click="$emit('confirm', '¿Desea cancelar venta?', 'Venta #{{$item->id_paddy}}', 'cancelarVenta', '{{$item->id}}')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>

    @include('shared.ventas.modal_sale_details')
    {{-- @include('livewire.productos.modal')
    @include('livewire.productos.modal_inventario') --}}
    
</div>