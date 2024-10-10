<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Seleccione Proveedor:</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Buscar</label>
                <input type="text" wire:model.lazy="searchValue" class="form-control" placeholder="Busqueda">
              </div>
              
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($proveedores as $proveedor)
                    <tr>
                      <td>{{ $proveedor->id_paddy }}</td>
                      <td>{{ $proveedor->nombre }}</td>
                      <td>{{ $proveedor->direccion }}</td>
                      <td>{{ $proveedor->correo }}</td>
                      <td>
                        <button wire:click="select({{ $proveedor->id }})" class="btn btn-sm btn-secondary"><i class="fa fa-user"></i> Seleccionar</button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
  
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
          {{ $proveedores->links() }}

        </div>
      </div>
      <!-- /.modal-content -->
    </div>
</div>