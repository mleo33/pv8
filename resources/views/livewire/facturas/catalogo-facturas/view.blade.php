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
            <label>Buscar:</label>
            <input type="text" class="form-control" wire:model.lazy="keyWord" placeholder="Folio / Cliente / RFC / Razón Social">
          </div>

          <div class="col-md-3">
            <label>Inicio:</label>
            <input type="date" class="form-control" wire:model.lazy="startDate">
          </div>

          <div class="col-md-3">
            <label>Final:</label>
            <input type="date" class="form-control" wire:model.lazy="endDate">
          </div>
        </div>

        <div class="row">
          <div class="col">
            <button class="btn btn-success btn-xs ml-3 mt-2" wire:click="exportToExcel"><i class="fa fa-file-excel"></i> Exportar a Excel</button>
          </div>
        </div>
        
        <table class="table table-hover">
          <thead>
            <tr>
              <th></th>
              <th>Fecha</th>
              <th>Folio</th>
              <th>Razón Social</th>
              <th>RFC</th>
              <th>Estatus</th>
              <th>Sub-Total</th>
              <th>Total</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($facturas as $item)
              <tr>
                <td><button class="btn btn-xs btn-default" wire:click="$emit('print', 'ticket_factura#{{$item->id}}')"><i class="fas fa-print"></i></button></td>
                <td>{{ $item->created_at->format('m/d/Y h:i A') }}</td>
                <td>{{$item->no_factura}}</td>
                <td>{{ $item->entidad_fiscal->razon_social }}</td>
                <td>{{ $item->entidad_fiscal->rfc }}</td>
                <td>{{ $item->estatus }}</td>
                <td> @money($item->subtotal) </td>
                <td> @money($item->total) </td>
                <td>
                  <div>
                    <button type="button" class="btn btn-default" data-toggle="dropdown"><i class="fa fa-cog"></i></button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="/facturacion/ver_pdf/{{$item->id}}" target="_blank"><i class="fas fa-file-pdf"></i> Ver PDF</a>
                      <a class="dropdown-item" href="/facturacion/xml/{{$item->id}}"><i class="fas fa-code"></i> Descargar XML</a>
                      <a class="dropdown-item" wire:click="showMdlMail({{$item->id}})" style="cursor: pointer;"><i class="fas fa-envelope"></i> Enviar Factura</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="/factura/{{$item->id}}/complementos"><i class="fa fa-file-alt"></i> Pagos ({{$item->complementos->count()}})</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" wire:click="$emit('initMdlCancelarFactura', {{$item->id}}, 'Factura')" style="cursor: pointer;"><i class="fa fa-times"></i> Cancelar Factura</a>
                    </div>
                  </div>
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