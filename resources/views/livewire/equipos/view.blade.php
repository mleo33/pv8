@section('title', __('Equipos'))
<div class="pt-4">

    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Catalogo de Equipos</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">

          <button wire:click="loadEquipo(0)" class="btn btn-sm btn-success m-2"><i class="fas fa-plus"></i> Agregar Equipo</button>
          <div class="form-group m-3">
            <label for="searchValueEquipos">Buscar</label>
            <input type="text" wire:model="searchValueEquipos" class="form-control" id="searchValueEquipos" placeholder="Busqueda">
          </div>

          <table class="table table-striped projects">
            <thead>
              <tr>
                <th>#</th>
                <th>FUA</th>
                <th>Familia</th>
                <th>Origen</th>
                <th>Modelo</th>
                <th>Descripción</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($equipos as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->fua }}</td>
                  <td>{{ $item->familia->nombre }}</td>
                  <td>{{ $item->origen }}</td>
                  <td>{{ $item->modelo }}</td>
                  <td>{{ $item->descripcion }}</td>
                  <td>
                    <button class="btn btn-sm btn-warning" wire:click="loadEquipo({{ $item->id }})"><i class="fa fa-edit"></i> Editar</button>
                    {{-- <button class="btn btn-xs btn-danger" onclick="destroy('{{ $item->id }}', 'producto: {{ $item->descripcion }}')"><i class="fas fa-trash"></i> Eliminar</button> --}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
        <!-- /.card-body -->
    </div>
    
</div>