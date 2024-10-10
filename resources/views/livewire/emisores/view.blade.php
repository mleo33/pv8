@section('title', __('Emisores Fiscales'))
<div class="mt-3">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Emisores Fiscales</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <table class="table table-hover">
        
        <button class="btn btn-sm btn-success m-2" data-toggle="modal" data-target="#mdl"><i class="fas fa-plus"></i>Agregar Emisor</button>

        <div class="form-group m-3">
          <label for="keyWord">Buscar</label>
          <input type="text" wire:keydown="resetPage()" wire:model="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">    
        </div>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>RFC</th>
            <th>Régimen Fiscal</th>
            <th>Sucursales</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($emisores as $row)
            <tr>              
              <td>{{ $row->nombre }}</td>
              <td>{{ $row->rfc }}</td>
              <td>{{ $row->regimen_fiscal . '-' . $regimenes_fiscales[$row->regimen_fiscal] }}</td>
              <td>
                @if ($row->sucursales->count() == 0)
                    N/A
                @else
                  <button wire:click="viewSucursales({{$row->id}})" class="btn btn-primary btn-sm"><i class="fas fa-store"></i> {{ $row->sucursales->count() }}</button>    
                @endif
                
              </td>
              <td>
                <button class="btn btn-xs btn-warning" wire:click="edit({{ $row->id }})"><i class="fa fa-edit"></i> Editar</a>
                @if ($row->sucursales->count() == 0)
                  <button class="ml-2 btn btn-xs btn-danger" onclick="destroy('{{ $row->id }}', 'Emisor: {{ $row->nombre }}')"><i class="fas fa-trash"></i> Eliminar</button> 
                @endif
                
              </td>
          @endforeach
        </tbody>
      </table>

    </div>

    <!-- /.card-body -->
  </div>
  {{ $emisores->links() }}

  @include('livewire.emisores.modal')
  @include('shared.sucursales.modal_sucursales', ['sucursales' => $this->emisor->sucursales])
</div>