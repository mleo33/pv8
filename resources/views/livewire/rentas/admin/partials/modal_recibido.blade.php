<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlRecibido">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                @if (isset($this->regIndex))
                    <h5 class="modal-title">{{ $renta->equipos[$this->regIndex]->descripcion }}</h5>    
                @endif
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <p class="d-flex flex-column">
                        <span class="text-muted">Recibió</span>
                        <span class="font-weight-bold">
                            {{$renta->equipos[$this->regIndex]->recibe->name}}
                        </span>
                    </p>
                </div>
                <div class="d-flex border-bottom mb-3">
                    <p class="d-flex flex-column">
                        <span class="text-muted">Fecha Recibido</span>
                        <span class="font-weight-bold">
                            {{$renta->equipos[$this->regIndex]->fecha_recibido_format()}}
                        </span>
                    </p>
                </div>
                @if ($renta->equipos[$this->regIndex]->horometro_inicio != 0)
                    <div class="d-flex justify-content-between border-bottom mb-3">
                        <p class="d-flex flex-column">
                            <span class="text-muted">Horómetro Inicio</span>
                            <span class="font-weight-bold">
                                {{$renta->equipos[$this->regIndex]->horometro_inicio}}
                            </span>
                        </p>
                        <p class="d-flex flex-column mr-5">
                            <span class="text-muted">Horómetro Final</span>
                            <span class="font-weight-bold">
                                {{$renta->equipos[$this->regIndex]->horometro_final}}
                            </span>
                        </p>
                    </div>
                @endif

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>