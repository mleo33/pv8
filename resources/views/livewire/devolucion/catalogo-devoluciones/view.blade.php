@section('title', __('Devoluciones'))
<div class="p-4">
    <div style="height: 85vh" class="card">
        <div class="card-header">
          <h3 class="card-title">{{$this->model_name_plural}}</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <x-date-range />
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Importe</th>
                <th>Venta</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $row)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $row->fecha_format }}</td>
                  <td>{{ $row->user->name }}</td>
                  <td>@money($row->importe)</td>
                  <td><a href="/venta/{{$row->venta_id}}" class="btn btn-xs btn-primary" target="_blank"><i class="fa fa-shopping-cart"></i> #@paddy($row->venta_id)</a></td>
                  <td>
                    <livewire:devolucion.common.btn-devolucion-detalles :devolucion="$row" :wire:key="'btn-dev-details-'.$row->id" />
                  </td>
                <tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
    </div>
    {{ $data->links() }}
</div>