<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectClient">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Seleccione Cliente:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group m-3">
              <label for="searchValueClientes">Buscar</label>
              <input type="text" wire:model.lazy="searchValueClientes" class="form-control" id="searchValueClientes" placeholder="Busqueda">
            </div>
            
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  {{-- <th>Fecha de alta</th> --}}
                  <th>Nombre</th>
                  <th>Dirección</th>
                  <th>Correo</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($clientes as $cliente)
                  <tr>
                    <td>{{ $cliente->id }}</td>
                    {{-- <td>{{ $cliente->created_at->diffForHumans() }}</td> --}}
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->direccion }}</td>
                    <td>{{ $cliente->correo }}</td>
                    <td>
                      <button wire:click="setClient({{ $cliente->id }})" class="btn btn-sm btn-secondary"><i class="fa fa-user"></i> Seleccionar</button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
        {{ $clientes->links() }}
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
  