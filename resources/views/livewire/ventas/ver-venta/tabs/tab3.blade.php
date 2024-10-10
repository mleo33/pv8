<div class="tab-pane {{ $activeTab == 3 ? 'active' : ''}}" id="tab_4">
    <div class="card m-0" style="min-height: 80vh">
        <div class="card-body p-0">
            @if ($this->venta->saldo > 0)
            <button data-toggle="modal" data-target="#mdlPago" class="btn btn-sm btn-success m-2"><i class="fas fa-dollar-sign"></i> Registrar Pago</button>
            @endif
            <table class="table table-striped projects">
            <thead>
                <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Tipo</th>
                <th>Forma de Pago</th>
                <th>Monto</th>
                <th>Imprimir Ticket</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venta->ingresos as $item)
                <tr @if ($item->canceled_at) style="color:red;" @endif>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $item->fecha_format() }}</td>
                    <td>{{ $item->usuario->name }}</td>
                    <td>{{ $item->tipo }}</td>
                    <td>{{ $item->forma_pago }}</td>
                    <td>
                    @money($item->monto)
                    </td>
                    <td>
                    @if ($item->canceled_by)
                        <button wire:click="mdlCancelBy({{$item}})" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> PAGO CANCELADO</button>
                    @else
                        <button wire:click="imprimirTicketAbono({{$item->id}})" class="btn btn-primary btn-xs"><i class="fa fa-print"></i> Imprimir Ticket</button>
                    @endif
                    </td>

                @endforeach
            </tbody>
            </table>
        </div>
        
        <div class="card-footer">
        </div>
    </div>
</div>