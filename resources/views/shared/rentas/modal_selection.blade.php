<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectRenta">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Seleccionar Renta
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group m-3">
                    <label>Buscar</label>
                    <input type="text" wire:keydown="resetPage()" wire:model="searchValueRentas" class="form-control" placeholder="Busqueda">
                </div>
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                          <th>ID Renta</th>
                          <th>Fecha</th>
                          <th>Vendedor</th>
                          <th>Cliente</th>
                          <th>Equipos</th>
                          <th>Monto</th>
                          <th>Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($rentas as $item)
                          <tr>
                            <td> @paddy($item->id) </td>
                            <td>{{ $item->fecha_format() }}</td>
                            <td>{{ $item->usuario->name }}</td>
                            <td>{{ $item->cliente->nombre }}</td>
                            <td><button wire:click="viewRegistros({{$item->id}})" class="btn btn-sm btn-warning"><i class="fas fa-caravan"></i> <b>{{ $item->equipos->count() }}</b></button></td>
                            <td>@money($item->total())</td>
                            <td>
                                <button wire:click="setRenta({{ $item->id }})" class="btn btn-sm btn-warning"><i class="fa fa-handshake"></i> Seleccionar</button>
                            </td>
                        @endforeach
                      </tbody>
                </table>
                {{ $rentas->links() }}
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>