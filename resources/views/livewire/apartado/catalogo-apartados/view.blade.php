@section('title', __('Claves de Producto'))
<div class="pt-3">
    <div style="min-height: 85vh" class="card">
        <div class="card-header">
          <h3 class="card-title">{{$this->model_name_plural}}</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          {{-- <x-date-range /> --}}

          @if ($data->count() > 0)              
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Folio</th>
                  <th>Fecha</th>
                  <th>Cliente</th>
                  <th>Importe</th>
                  <th>Vigencia</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $row)
                  <tr>
                    <td>{{ $row->id_paddy }}</td>
                    <td>{{ $row->fecha_format }}</td>
                    <td>{{ $row->cliente->nombre }}</td>
                    <td>@money($row->importe)</td>
                    <td>{{ $row->vence_format }}</td>
                    <td>
                      <button wire:click="$emit('initMdlViewApartado', {{$row}})" class="btn btn-xs btn-primary"><i class="fa fa-clock"></i> Ver Apartado</button>
                      <button wire:click="$emit('print', 'ticket_apartado#{{$row->id}}')" class="btn btn-xs btn-default"><i class="fa fa-print"></i> Ticket</button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <div class="p-3">
              <h3>No existen productos apartados</h3>
            </div>
          @endif
          
        </div>
    </div>
    {{ $data->links() }}

    <livewire:apartado.common.mdl-view-apartado />
    <livewire:apartado.common.mdl-abono-apartado />
    <livewire:ingreso.common.mdl-cash-payment/>
</div>