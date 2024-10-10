<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlSaleDetails">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Venta: #@paddy($venta?->id)
                @if ($venta?->cliente)
                    - {{$venta->cliente->nombre}}
                @endif
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click.prevent="cancel()">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($this->venta?->registros ?? [] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->codigo }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>@qty($item->cantidad)</td>
                            <td>@money($item->precio)</td>
                            <td>@money($item->importe())</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if ($venta?->comentarios)
                    <h4>Comentarios</h4>
                    <table class="table table-hover">
                        <tbody>
                            @foreach($this->venta?->comentarios ?? [] as $elem)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $elem->created_at->format('m/d/Y h:i A') }}</td>
                                <td>{{ $elem->usuario->name }}</td>
                                <td>
                                    @if ($elem->tipo == 'CANCELACION')
                                       <button class="btn btn-danger btn-xs"><i class="fa fa-times"></i> CANCELACIÓN</button>
                                    @endif
                                    {{ $elem->mensaje }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                @endif

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                <!-- @if (false)
                    <button type="button" wire:click.prevent="update()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                @else
                    <button type="button" wire:click.prevent="update()" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                @endif -->
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>