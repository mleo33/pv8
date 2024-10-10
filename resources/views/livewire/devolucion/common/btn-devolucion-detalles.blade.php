<div class="d-inline">
    <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#{{$this->modalName}}">
        <i class='fa fa-info'></i> Ver Detalles
    </button>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->modalName}}">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Devolución #@paddy($this->devolucion->id)</h5>
                    <button type="button" class="close" data-toggle="modal" data-target="#{{$this->modalName}}" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="height: 100vh" class="modal-body">
                    <h3>Producto: {{$this->devolucion->descripcion}}</h3>
                    <div class="row">
                        <div class="col">
                            <h4>Fecha: {{$this->devolucion->fecha_format}}</h4>
                            <h4>Venta: <a class="btn btn-sm btn-primary" href="/venta/{{$this->devolucion->venta_id}}" target="_blank"><i class="fa fa-shopping-cart"></i> #@paddy($this->devolucion->venta_id)</a></h4>
                            <h4>Usuario: {{$this->devolucion->user->name}}</h4>
                        </div>
                        <div class="col">
                            <h4>Cantidad: {{$this->devolucion->cantidad}}</h4>
                            <h4>Precio: @money($this->devolucion->precio)</h4>
                            <h4>Importe: @money($this->devolucion->importe)</h4>
                        </div>
                    </div>

                    <br>
                    <h4>Cambios:</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach ($this->devolucion->cambios as $item)                           
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->codigo}}</td>
                                <td>{{$item->descripcion}}</td>
                                <td align="center">{{$item->cantidad}}</td>
                                <td align="right">@money($item->precio)</td>
                                <td align="right">@money($item->importe)</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer justify-content-between">
                    <button data-toggle="modal" data-target="#{{$this->modalName}}" type="button" class="btn btn-secondary"><i class="fas fa-window-close"></i> Cerrar</button>
                </div>
            </div>
            
        </div>
    </div>
</div>