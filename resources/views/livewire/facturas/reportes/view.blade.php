<div class="pt-4">

    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Facturas Emitidas</h3>
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
          
          <table class="table table-hover">
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
                <th>Opciones</th>
                <th>Complementos</th>
              </tr>
            </thead>
            <tbody>
              @foreach($facturas as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
				          <td>{{ $item->created_at->format('m/d/Y h:i A') }}</td>
                  <td> @paddy($item->id) </td>
                  <td>{{ $item->usuario->name }}</td>
                  <td>{{ $item->entidad_fiscal->razon_social }}</td>
                  <td>{{ $item->estatus }}</td>
                  <td> @money($item->subtotal) </td>
                  <td> @money($item->total) </td>
                  <td>
                    <a class="btn btn-xs btn-primary" href="/facturacion/ver_pdf/{{$item->id}}" target="_blank"><i class="fas fa-file-pdf"></i> PDF</a>
                    <a class="btn btn-xs btn-primary" href="/facturacion/xml/{{$item->id}}" target="_blank"><i class="fas fa-code"></i> XML</a>
                    <button class="btn btn-xs btn-warning" wire:click="mdlEnviarFactura({{$item->id}})"><i class="fas fa-envelope"></i> Enviar Correo</button>
                    <button class="btn btn-xs btn-default" wire:click="$emit('print', 'ticket_factura#{{$item->id}}')"><i class="fas fa-print"></i></button>
                  </td>
                  <td>
                    <a href="/factura/{{$item->id}}/complementos" class="btn btn-xs btn-primary"><i class="fa fa-file-alt"></i> Pagos 
                      @if ($item->complementos->count() > 0)
                        ({{$item->complementos->count()}})
                      @endif
                    </a>
                  </td>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>

    @if ($this->factura->id)
      @include('shared.facturacion.modal_enviar_factura')
    @endif
    
</div>