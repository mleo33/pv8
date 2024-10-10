@section('title', __('Traslados'))
<div class="pt-4">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Traslados</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
            <button class="btn btn-sm btn-success m-2" data-toggle="modal" data-target="#mdl">
              <i class="fas fa-plus"></i> Agregar Traslado</button>
            <div class="form-group m-3">
              <label for="keyWord">Buscar</label>
              <input type="text" wire:model="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
            </div>
            <thead>
              <tr>
                <th>#</th>
                <th>Destino</th>
                <th>Viaje Sencillo</th>
                <th>Viaje Redondo</th>
                <th>Comentarios</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($traslados as $row)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $row->destino }}</td>
                  <td>@money($row->sencillo)</td>
                  <td>@money($row->redondo)</td>
                  <td>{{ $row->comentarios }}</td>
                  <td>
                    <button class="btn btn-sm btn-warning" wire:click="edit({{ $row->id }})"><i class="fa fa-edit"></i> Editar</button>
                    <button class="btn btn-sm btn-danger" onclick="destroy('{{ $row->id }}', 'Traslado a {{ $row->destino }}')"><i class="fas fa-trash"></i> Eliminar</button>
                  </td>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>
    {{ $traslados->links() }}

    @include('livewire.traslados.modal')
</div>