<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdl">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <p class="lead">Recarga #@paddy($this->selectedRecarga->id)</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Folio:</th>
                                        <td>{{$this->selectedRecarga->folio ? $this->selectedRecarga->folio : "N/A"}}</td>

                                        <th style="width:50%">ID Transacción:</th>
                                        <td>{{$this->selectedRecarga->trans_id}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Fecha:</th>
                                        <td>{{$this->selectedRecarga->fecha_format}}</td>

                                        <th style="width:50%">Categoria:</th>
                                        <td>{{$this->selectedRecarga->categoria}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Compañia:</th>
                                        <td>{{$this->selectedRecarga->compania}}</td>

                                        <th style="width:50%">Código de Producto:</th>
                                        <td>{{$this->selectedRecarga->producto}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Monto:</th>
                                        <td>@money($this->selectedRecarga->monto)</td>

                                        <th style="width:50%">Estatus:</th>
                                        <td><button class="btn btn-xs btn-{{$this->selectedRecarga->color}}">{{$this->selectedRecarga->estatus}}</button></td>
                                    </tr>

                                </table>
                                <table class="table">
                                    <tr>
                                        <th>Notas:</th>
                                        <td>{{$this->selectedRecarga->mensaje}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>