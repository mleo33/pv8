<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlRentDetails">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Renta: #@paddy($renta->id)
                @if ($renta->cliente)
                    - {{$renta->cliente->nombre}}
                @endif
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click.prevent="cancel()">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>FUA</th>
                        <th>Descripción</th>
                        <th>Renta</th>
                        <th>Importe</th>
                        <th>Retorno</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($this->renta->equipos as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->fua }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ $item->tiempo_renta() }}</td>
                            <td>@money($item->importe())</td>
                            <td>{{ $item->retorno_format() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if ($renta->comentarios)
                    <h4>Comentarios</h4>
                    <p>{{$renta->comentarios}}</p>
                @endif

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>