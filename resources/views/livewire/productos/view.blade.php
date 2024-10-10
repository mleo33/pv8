@section('title', __('Productos'))
<div class="pt-4">

    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Catalogo de Productos</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">

          
          <div class="form-group m-3">
            <label for="keyWord">Buscar</label>
            <input type="text" wire:keydown="resetPage()" wire:model.lazy="keyWord" class="form-control" id="keyWord" placeholder="Busqueda">
          </div>
          <button class="btn btn-xs btn-success m-2" wire:click="mdlNewProduct"><i class="fas fa-plus"></i> Agregar Producto</button>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Marca</th>
                <th>Descripción</th>
                <th>Unidad</th>
                <th>Existencia</th>
                <th>Precio</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($productos as $elem)
                <tr>
                  <td>{{ $elem->id }}</td>
				          <td>{{ $elem->codigo }}</td>
                  <td>{{ $elem->marca }}</td>
                  <td>{{ $elem->descripcion }}</td>
                  <td>{{ $elem->unidad }}</td>
                  <td>{{ $elem->inventario_actual() ? ($elem->inventario_actual()->qty_disponible() ?? 0) : 0 }}</td>
                  <td>@money($elem->inventario_actual()->precio ?? 0)</td>
                  <td>
                    <a class="btn btn-xs btn-primary" wire:click="showInventario({{ $elem->id }})"><i class="fa fa-boxes"></i> Inventario</a>
                    <a class="btn btn-xs btn-warning" wire:click="edit({{ $elem->id }})"><i class="fa fa-edit"></i> Editar</a>
                    <button class="btn btn-xs btn-danger" onclick="destroy('{{ $elem->id }}', 'producto: {{ $elem->descripcion }}')"><i class="fas fa-trash"></i> Eliminar</button>
                  </td>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>
    {{ $productos->links() }}

    @include('livewire.productos.modal')
    @include('livewire.productos.modal_inventario_sucursales')
    @include('livewire.productos.modal_inventario')
    @include('livewire.productos.modal_entradas_salidas')

    @include('livewire.productos.partials.modal-marca')
    @include('livewire.productos.partials.modal-clave-producto')
    @include('livewire.productos.partials.modal-clave-unidad')
    
</div>