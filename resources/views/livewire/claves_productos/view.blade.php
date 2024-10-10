@section('title', __('Claves de Producto'))
<div class="p-4">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{$this->model_name_plural}} (Catálogo SAT)</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
            <button class="btn btn-sm btn-success m-2" wire:click="mdlCreate"><i class="fas fa-plus"></i> Agregar {{$this->model_name}}</button>
            <div class="form-group m-3">
              <label for="keyWord">Buscar</label>
              <input type="text" wire:model.debounce.1s="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
            </div>
            <thead>
              <tr>
                <th>#</th>
                <th>Clave</th>
                <th>Descripción</th>
                <th>Cant. Productos</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $row)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $row->clave }}</td>
                  <td>{{ $row->nombre }}</td>
                  <td>
                    @if ($row->productos->count() > 0)  
                      <button style="min-width: 30px;" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> {{ $row->productos->count() }}</button>
                    @else
                      N/A
                    @endif
                  </td>
                  <td>
                    <button class="btn btn-sm btn-warning" wire:click="mdlEdit({{ $row->id }})"><i class="fa fa-edit"></i> Editar</button>
                    @if ($row->productos->count() == 0)  
                    <button class="btn btn-sm btn-danger" wire:click="mdlDelete({{ $row->id }})"><i class="fas fa-trash"></i> Eliminar</button>
                    @endif
                  </td>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>
    {{ $data->links() }}

    @include('livewire.claves_productos.modal')
</div>