<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlActiveRents">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Rentas activas - {{$cliente->nombre}}
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th>ID Renta</th>
                        <th>Fecha</th>
                        <th>Vendedor</th>
                        <th>Equipos</th>
                        <th>Monto</th>
                        <th>Saldo Pendiente</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($cliente->rentas_activas as $elem)
                        <tr>
                            <td>@paddy($elem->id)</td>
                            <td>{{ $elem->fecha_format() }}</td>
                            <td>{{ $elem->usuario->name }}</td>
                            <td><button class="btn btn-sm btn-warning"><i class="fas fa-caravan"></i> <b>{{ $elem->equipos->count() }}</b></button></td>
                            <td>@money($elem->total())</td>
                            <td>@money($elem->saldo_pendiente())</td>
                            <td>
                                <a href="administrar_renta/{{$elem->id}}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-handshake"></i> Ver Renta</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>