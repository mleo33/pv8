<div class="pt-4">

    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Rentas Realizadas</h3>
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

          <div class="row m-2">
            <div class="col-md-12">
              <label>Buscar</label>
              <input type="text" wire:keydown="resetPage()" class="form-control" wire:model="searchValue">
            </div>
          </div>
          
          <table class="table table-striped projects">
            <thead>
              <tr>
                <th>ID Renta</th>
                <th>Fecha</th>
                <th>Vendedor</th>
                <th>Cliente</th>
                <th>Equipos</th>
                <th>Monto</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rentas as $item)
                <tr>
                  <td> @paddy($item->id) </td>
				          <td>{{ $item->created_at->format('m/d/Y h:i A') }}</td>
                  <td>{{ $item->usuario->name }}</td>
                  <td>{{ $item->cliente->nombre }}</td>
                  <td><button wire:click="viewRegistros({{$item->id}})" class="btn btn-sm btn-warning"><i class="fas fa-caravan"></i> <b>{{ $item->equipos->count() }}</b></button></td>
                  <td>@money($item->total())</td>
                  <td>
                    <a href="administrar_renta/{{$item->id}}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-handshake"></i> Ver Renta</a>
                  </td>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>
    {{ $rentas->links() }}

    {{-- @include('livewire.productos.modal')
    @include('livewire.productos.modal_inventario') --}}
    @include('shared.rentas.modal_rent_details')
    
</div>