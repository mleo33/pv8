<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{ $this->mdlName }}">
    <div style="min-height: 85vh;" class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Apartado #{{ $this->apartado?->id_paddy }}</h5>
                <button type="button" class="close" data-toggle="modal" data-target="#{{ $this->mdlName }}"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">
                        <h6><b>Fecha:</b> <br>{{ $this->apartado?->fecha_format }}</h6>
                        <hr>
                        <h6><b>Usuario:</b> <br>{{ $this->apartado?->user->name }}</h6>
                        <hr>
                        <h6><b>Cliente:</b> <br>{{ $this->apartado?->cliente->nombre }}</h6>
                        <hr>
                        <h6><b>Pagado:</b> <br>@money($this->apartado?->pagado())</h6>
                        <hr>
                        <h6><b>Saldo Pendiente:</b> <br>@money($this->apartado?->saldo)</h6>
                        <hr>
                        <h6><b>Vence:</b>
                            <br>En {{ $this->apartado?->faltaParaVencer }}
                            <br>{{ $this->apartado?->vence_format }}
                        </h6>
                    </div>
                    <div class="col-9">

                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a wire:ignore.self class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                            href="#custom-tabs-four-home" role="tab"
                                            aria-controls="custom-tabs-four-home" aria-selected="true">Productos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a  wire:ignore.self class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                            href="#custom-tabs-four-profile" role="tab"
                                            aria-controls="custom-tabs-four-profile" aria-selected="false">Abonos</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div style="min-height: 70vh;" class="tab-content" id="custom-tabs-four-tabContent">
                                    <div wire:ignore.self class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($this->apartado->conceptos ?? [] as $item)
                                                    <tr>
                                                        <td>{{ $item->codigo }}</td>
                                                        <td>{{ $item->descripcion }}</td>
                                                        <td>{{ $item->cantidad }}</td>
                                                        <td>@money($item->precio)</td>
                                                        <td>@money($item->importe)</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div wire:ignore.self class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Usuario</th>
                                                    <th>Tipo</th>
                                                    <th>Forma Pago</th>
                                                    <th>Monto</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($this->apartado->ingresos ?? [] as $item)
                                                    <tr>
                                                        <td>{{ $item->fecha_format }}</td>
                                                        <td>{{ $item->usuario->name }}</td>
                                                        <td>{{ $item->tipo }}</td>
                                                        <td>{{ $item->forma_pago }}</td>
                                                        <td>@money($item->monto)</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button data-toggle="modal" class="btn btn-secondary" data-target="#{{ $this->mdlName }}"><i
                        class="fas fa-window-close"></i> Cancelar</button>
                <button wire:click="$emit('initMdlAbonoApartado', {{ $this->apartado }}, 'mdlCashPayment')"
                    class="btn btn-primary"><i class="fas fa-dollar-sign"></i> Abonar</button>
                <button wire:click="mdlPagoRetiro" class="btn btn-success"><i class="fas fa-cash-register"></i> Retirar</button>
            </div>
        </div>

    </div>
</div>
