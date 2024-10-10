<div class="tab-pane {{ $activeTab == 5 ? 'active' : ''}}" id="tab_4">
    <div class="card m-0" style="min-height: 80vh">
        <div class="card-body p-0">
            @if (true)
            <button data-toggle="modal" data-target="#mdlComentario" class="btn btn-sm btn-success m-2"><i class="fas fa-comment"></i> Agregar Comentarios</button>
            @endif
            <table class="table table-striped projects">
            <thead>
                <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Mensaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->venta->comentarios ?? [] as $elem)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $elem->created_at->format('m/d/Y h:i A') }}</td>
                    <td>{{ $elem->usuario->name }}</td>
                    <td>
                    @if ($elem->tipo == 'CANCELACION')
                    <button class="btn btn-danger btn-xs"><i class="fa fa-times"></i> CANCELACIÓN</button>
                    @endif
                    {{ $elem->mensaje }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        
        <div class="card-footer">
        </div>
    </div>
</div>