<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectVenta">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Seleccionar Venta
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group m-3">
                    <label>Buscar</label>
                    <input type="text" wire:keydown="resetPage()" wire:model="searchValueVentas" class="form-control" placeholder="Busqueda">
                </div>
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>ID Venta</th>
                            <th>Fecha</th>
                            <th>Vendedor</th>
                            <th>Cliente</th>
                            <th>Productos</th>
                            <th>Monto</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($ventas as $item)
                        <tr>
                            <td> @paddy($item->id) </td>
                            <td>{{ $item->fecha_format() }}</td>
                            <td>{{ $item->usuario->name }}</td>
                            <td>{{ $item->cliente->nombre ?? 'NO IDENTIFICADO' }}</td>
                            <td><button wire:click="viewRegistros({{$item->id}})" class="btn btn-sm btn-primary"><i class="fas fa-shopping-basket"></i> <b>{{ $item->totalProductos() }}</b></button></td>
                            <td>@money($item->total())</td>
                            <td>
                                <button wire:click="setVenta({{ $item->id }})" class="btn btn-sm btn-primary"><i class="fa fa-shopping-basket"></i> Seleccionar</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $ventas->links() }}

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>