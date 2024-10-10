<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlRentaPrecios">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $equipo->fua }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>Tipo de Renta</th>
                            <th>Precio</th>
                            <th>Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($equipo->renta_hora > 0)
                            <tr>
                                <td>HORA</td>
                                <td>@money($equipo->renta_hora)</td>
                                <td><button wire:click="agregarEquipo('HORA')" class="btn btn-sm btn-secondary"><i class="fa fa-dollar-sign"></i> Seleccionar</button></td>
                            </tr>
                        @endif
                        @if ($equipo->renta_dia > 0)
                            <tr>
                                <td>DÍA</td>
                                <td>@money($equipo->renta_dia)</td>
                                <td><button wire:click="agregarEquipo('DIA')" class="btn btn-sm btn-secondary"><i class="fa fa-dollar-sign"></i> Seleccionar</button></td>
                            </tr>
                        @endif
                        @if ($equipo->renta_semana > 0)
                            <tr>
                                <td>SEMANA</td>
                                <td>@money($equipo->renta_semana)</td>
                                <td><button wire:click="agregarEquipo('SEMANA')" class="btn btn-sm btn-secondary"><i class="fa fa-dollar-sign"></i> Seleccionar</button></td>
                            </tr>
                        @endif
                        @if ($equipo->renta_mes > 0)
                            <tr>
                                <td>MES</td>
                                <td>@money($equipo->renta_mes)</td>
                                <td><button wire:click="agregarEquipo('MES')" class="btn btn-sm btn-secondary"><i class="fa fa-dollar-sign"></i> Seleccionar</button></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
            </div>

        </div>
    </div>
</div>
