<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSelectClaveProducto">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Seleccione Clave de Producto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @if ($claveCreateMode)
                    <button wire:click="$toggle('claveCreateMode')" class="mb-3 btn btn-xs btn-default"><i class="fa fa-long-arrow-alt-left"></i> Regresar</button>
                    <form>
                        <div class="row">
                            <div class="col-5">
                                <div class="form-group">
                                    <label for="claveProducto.clave">Clave</label>
                                    <input style="text-transform: uppercase;" wire:model="claveProducto.clave" type="text" name="claveProducto.clave" maxlength="30" class="form-control" />
                                    @error('claveProducto.clave') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="claveProducto.nombre">Nombre</label>
                                    <input wire:model="claveProducto.nombre" type="text" name="claveProducto.nombre" maxlength="255" class="form-control" />
                                    @error('claveProducto.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>    
                                <div class="form-group">
                                    <button type="button" wire:click="createClaveProducto" class="btn btn-success"><i class="fa fa-plus"></i> Agregar Clave</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <button wire:click="$toggle('claveCreateMode')" class="mb-3 btn btn-xs btn-primary"><i class="fa fa-plus"></i> Agregar Clave</button>          
                    <div class="form-group m-3">
                        <label>Buscar</label>
                        <input type="text" wire:keydown="resetPage()" wire:model="searchValueClaveProductos" class="form-control" placeholder="Busqueda">
                    </div>
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Clave</th>
                            <th>Nombre</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clave_productos as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->clave }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>
                                    <button wire:click="setClaveProducto('{{ $item->clave }}')" class="btn btn-sm btn-secondary"><i class="fa fa-check"></i> Seleccionar</button>
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $clave_productos->links() }}
                @endif
                
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>