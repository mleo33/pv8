@section('title', __('Clientes'))
<div class="pt-4">

    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Catalogo de Clientes</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">         

          <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-success m-3" data-toggle="modal" data-target="#mdl"><i class="fas fa-plus"></i> Agregar Cliente</button>
          </div>

          <div class="form-group m-3">
            <label for="keyWord">Buscar</label>
            <input type="text" wire:keydown="resetPage()" wire:model="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
          </div>
          
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfonos</th>
                <th>Reportes</th>
                <th>Opciones</th>
                <th><i class="fas fa-trash"></i></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($clientes as $cliente)
                <tr>
                  <td>{{ $cliente->id }}</td>
                  <td>{{ $cliente->nombre }}</td>
                  <td>{{ $cliente->direccion }}</td>
                  <td>
                    @if ($cliente->telefonos->count() > 0)
                      <button wire:click="showTelefonos({{$cliente->id}})" class="btn btn-sm btn-primary"><i class="fa fa-phone"></i> {{$cliente->telefonos->count()}}</button>
                    @else
                      N/A
                    @endif
                  </td>
                  <td>
                    <a class="btn btn-xs btn-secondary" href="/clientes/{{$cliente->id}}/edo_cta" target="_blank"><i class="fas fa-file-alt"></i> Edo. Cta</a>
                  </td>
                  <td>
                    <button class="btn btn-xs btn-primary" wire:click="edit({{ $cliente->id }})"><i class="fa fa-user"></i> Ver Cliente</button>
                  </td>
                  <td><button class="btn btn-xs btn-danger" onclick="destroy('{{ $cliente->id }}', '{{ $cliente->nombre }}')"><i class="fas fa-times"></i></button></td>
                </tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>
    {{ $clientes->links() }}

    @include('livewire.clientes.modal')
    @include('shared.clientes.modal-telefonos')
    
</div>





