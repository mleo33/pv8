@section('title', __('Pedidos'))
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
            <a href="/pedidos/crear-pedido" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Crear Pedido</a>
          </div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Importe</th>
                <th>Estatus</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $row)
                <tr>
                  <td>{{ $row->id_paddy }}</td>
                  <td>{{ $row->fecha_format }}</td>
                  <td>{{ $row->user->name }}</td>
                  <td>@money($row->total)</td>
                  <td>{{ $row->estatus_recibido }}</td>
                  <td>
                      <button wire:click="mdlEnviarCorreo({{$row->id}})" class="btn btn-xs btn-warning"><i class="fa fa-envelope"></i> Enviar Pedido</button>
                      <a href='/pedidos/pdf/{{$row->id}}' target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-file-alt"></i> Ver Pedido</a>
                      <button wire:click="$emit('initMdlRecibirPedido',{{$row}})" class="btn btn-xs btn-success"><i class="fa fa-truck"></i> Recibir Pedido</button>
                  </td>
                <tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
    </div>
    {{ $data->links() }}
</div>