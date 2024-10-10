<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Catálogo de Ventas</h3>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha Inicio</label>
                        <input type="date" class="form-control" wire:model="dateStart">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="fecha_fin">Fecha Fin</label>
                        <input type="date" class="form-control" wire:model="dateEnd">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="fecha_fin">Buscar</label>
                        <input type="text" class="form-control" wire:model.lazy="keyWord">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="fecha_fin">Usuario</label>
                        <select class="form-control" wire:model="user_id">
                            <option value="">Todos</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button style="margin-top: 45px;" class="btn btn-success btn-xs" wire:click="exportToExcel"><i
                            class="fa fa-file-excel"></i> Exportar a Excel</button>
                </div>

            </div>

            <div class="row">

                <div class="col">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
    
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Ventas</b></span>
                            <span class="info-box-number">@money($total_ventas_activas)</span>
                        </div>
    
                    </div>
                </div>
    
                <div class="col">
                    <div class="info-box" wire:click="$set('activeTab', 5)" style="cursor: pointer;">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>
    
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Canceladas</b></span>
                            <span class="info-box-number">@money($total_ventas_canceladas)</span>
                        </div>
    
                    </div>
                </div>
    
                <div class="col">
                    <div class="info-box" wire:click="$set('activeTab', 5)" style="cursor: pointer;">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-dollar-sign"></i></span>
    
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Total</b></span>
                            <span class="info-box-number">@money($total_ventas)</span>
                        </div>
    
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID Venta</th>
                        <th>Fecha</th>
                        <th>Vendedor</th>
                        <th>Cliente</th>
                        <th>Productos</th>
                        <th>Monto Original</th>
                        <th>Monto Venta</th>
                        <th>Ver venta</th>
                        <th>Cancelar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $item)
                        <tr>
                            <td><a class="btn btn-default" href="aosprint:ticket_venta#{{ $item->id }}">
                                    @paddy($item->id) </a></td>
                            <td>{{ $item->created_at->format('m/d/Y h:i A') }}</td>
                            <td>{{ $item->usuario->name }}</td>
                            <td>{{ $item->cliente->nombre ?? 'NO IDENTIFICADO' }}</td>
                            <td><button wire:click="viewRegistros({{ $item->id }})"
                                    class="btn btn-sm btn-primary"><i class="fas fa-shopping-basket"></i>
                                    <b>{{ $item->totalProductos() }}</b></button></td>
                            <td>@money($item->total_actual)</td>
                            <td>@money($item->total())</td>

                            @if ($item->is_canceled)
                                <td>CANCELADA</td>
                                <td style="color: red;">
                                    <p style=" margin: 0px;">Cancelado por: {{ $item->user_cancel->name }}</p>
                                    <small>{{ $item->canceled_at_format }}</small>
                                </td>
                            @else
                                <td>
                                    <a href="venta/{{ $item->id }}" class="btn btn-sm btn-primary"><i
                                            class="fas fa-shopping-cart"></i> Ver Venta</a>
                                </td>
                                <td><button
                                        wire:click="$emit('confirm', '¿Desea cancelar venta?', 'Venta #{{ $item->id_paddy }}', 'cancelarVenta', '{{ $item->id }}')"
                                        class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $ventas->links() }}
        </div>
    </div>

    @include('shared.ventas.modal_sale_details')

</div>
