<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlCancelBy">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Descripcion</h5>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <p class="d-flex flex-column">
                        <span class="text-muted">Cancelado por:</span>
                        <span class="font-weight-bold">
                            {{$item->cancelado_por->name}}
                        </span>
                    </p>
                </div>
                <div class="d-flex border-bottom mb-3">
                    <p class="d-flex flex-column">
                        <span class="font-weight-bold">
                            <span class="text-muted">Fecha Cancelación</span>
                            {{$item->fecha_cancelacion}}
                        </span>
                    </p>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>