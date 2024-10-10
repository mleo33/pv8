<div class="pt-4">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Historial de Recargas Tiempo Aire</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body p-0">

            <div class="row m-2">
                <div class="col-md-6">
                    <label>Inicio</label>
                    <input type="date" class="form-control" wire:model.lazy="startDate">
                </div>

                <div class="col-md-6">
                    <label>Final:</label>
                    <input type="date" class="form-control" wire:model.lazy="endDate">
                </div>
            </div>

            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Compañia</th>
                        <th>Producto</th>
                        <th>Monto</th>
                        <th>Estatus</th>
                        <th>ID Transacción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recargas as $item)
                    <tr>
                        <td>@paddy($item->id)</td>
                        <td>{{ $item->created_at->format('m/d/Y h:i A') }}</td>
                        <td>{{ $item->usuario->name }}</td>
                        <td>{{ $item->compania }}</td>
                        <td>{{ $item->producto }}</td>
                        <td>@money($item->monto)</td>
                        <td><h5><span class="badge badge-{{$item->color}}">{{ $item->estatus }}</span></h5></td>
                        <td>
                            @if ($item->trans_id)
                                <button wire:click="viewDetails({{$item->id}})" class="btn btn-sm btn-primary">{{$item->trans_id}}</button>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>

    @if ($this->selectedRecarga)
        @include('livewire.recargas.historial.modal')
    @endif

</div>