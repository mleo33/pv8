@section('title', __('Cotizaciones'))
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
          <x-date-range />
          <div class="mt-3 ml-3">
            <a href="/cotizaciones/crear-cotizacion" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Crear Cotización</a>
          </div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Cliente</th>
                <th>Importe</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $row)
                <tr>
                  <td>{{ $row->id_paddy }}</td>
                  <td>{{ $row->fecha_format }}</td>
                  <td>{{ $row->usuario->name }}</td>
                  <td>{{ $row->cliente->nombre ?? "PUBLICO EN GENERAL" }}</td>
                  <td>@money($row->total)</td>
                  <td>
                      <button wire:click="mdlEnviarCorreo({{$row->id}})" class="btn btn-xs btn-warning"><i class="fa fa-envelope"></i> Enviar</button>
                      <a href='/cotizaciones/pdf/{{$row->id}}' target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-file-alt"></i> Ver Cotización</a>
                  </td>
                <tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
    </div>
    {{ $data->links() }}
</div>