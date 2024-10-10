<div class="tab-pane {{ $activeTab == 4 ? 'active' : ''}}" id="tab_5">
    <div class="card m-0" style="min-height: 80vh">
        <div class="card-body p-0">
            <table class="table table-striped projects">
            <thead>
                <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Folio</th>
                <th>Usuario</th>
                <th>Razón Social</th>
                <th>Estatus</th>
                <th>Sub-Total</th>
                <th>Total</th>
                <th>PDF</th>
                {{-- <th>Cancelar</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($venta->facturas as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->created_at->format('m/d/Y h:i A') }}</td>
                    <td> @paddy($item->id) </td>
                    <td>{{ $item->usuario->name }}</td>
                    <td>{{ $item->entidad_fiscal->razon_social}}</td>
                    <td>{{ $item->estatus }}</td>
                    <td> @money($item->subtotal) </td>
                    <td> @money($item->total) </td>


                    {{-- <td><button wire:click="viewRegistros({{$item->id}})" class="btn btn-sm btn-primary"><i class="fas fa-shopping-basket"></i> <b>{{ $item->totalProductos() }}</b></button></td>
                    <td>@money($item->total())</td> --}}
                    <td>
                    <a class="btn btn-xs btn-primary" href="/facturacion/ver_pdf/{{$item->id}}" target="_blank"><i class="fas fa-file-pdf"></i> Ver PDF</a>
                    </td>
                    {{-- <td>
                    <button class="btn btn-xs btn-danger" onclick="destroy('{{ $item->id }}', 'venta: {{ $item->id }}')"><i class="fas fa-times"></i> Cancelar</button>
                    </td> --}}
                @endforeach
            </tbody>
            </table>
        </div>
        
        <div class="card-footer">
        </div>
    </div>
</div>