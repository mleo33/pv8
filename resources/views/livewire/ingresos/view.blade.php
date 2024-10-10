<div class="pt-4">

    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Ingresos</h3>
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

          <div class="row m-2">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-wave"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text"><b>EFECTIVO</b></span>
                  <span class="info-box-number">@money($ingresos->where('forma_pago', 'EFECTIVO')->where('canceled_at', null)->where('canceled_at', null)->sum('monto'))</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-credit-card"></i></span>

                <div class="info-box-content">
                  @php
                      //DEUDA_TECNICA
                      $tarjetas = $ingresos->where('forma_pago', 'TARJETA')->where('canceled_at', null)->sum('monto');
                  @endphp
                  <span class="info-box-text"><b>TARJETAS</b></span>
                  <span class="info-box-number">@money($tarjetas)</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-university"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text"><b>TRANSFERENCIAS</b></span>
                  <span class="info-box-number">@money($ingresos->where('forma_pago', 'TRANSFERENCIA')->where('canceled_at', null)->sum('monto'))</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text"><b>TOTAL</b></span>
                  <span class="info-box-number">@money($ingresos->where('canceled_at', null)->sum('monto'))</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>

          <table class="table table-striped projects">
            <thead>
              <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Tipo</th>
                <th>Forma de Pago</th>
                <th>Monto</th>
                <th>Corresponde a:</th>
                {{-- <th>Cliente</th>
                <th>Productos</th>
                <th>Monto</th>
                <th>Cancelar</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach($ingresos as $item)
                <tr @if ($item->canceled_at) class="text-danger" @endif>
                  <td>{{$loop->iteration}}</td>
				          <td>{{ $item->created_at->format('M/d/Y h:i A') }}</td>
                  <td>{{ $item->usuario->name }}</td>
                  <td>{{ $item->tipo }}</td>
                  <td>{{ $item->forma_pago }}</td>
                  <td>@money($item->monto)</td>
                  @if ($item->folio_de() == "VENTA")
                    <td><button wire:click="viewVenta({{$item->model_id}})" class='btn btn-sm btn-primary'><i class='fas fa-shopping-cart'></i> {{ $item->folio_de() }} #@paddy($item->model_id)</button></td>    
                  @endif
                  @if ($item->folio_de() == "RENTA")
                    <td><a href="administrar_renta/{{$item->model_id}}" target="_blank" class='btn btn-sm btn-warning'><i class='fas fa-caravan'></i> {{ $item->folio_de() }} #@paddy($item->model_id)</a></td>    
                  @endif
                  
                  {{-- <td>{{ $item->cliente->nombre ?? 'NO IDENTIFICADO' }}</td>
                  <td><button wire:click="viewRegistros({{$item->id}})" class="btn btn-sm btn-primary"><i class="fas fa-shopping-basket"></i> <b>{{ $item->totalProductos() }}</b></button></td>
                  <td>@money($item->total())</td>
                  <td>
                    <button class="btn btn-xs btn-danger" onclick="destroy('{{ $item->id }}', 'venta: {{ $item->id }}')"><i class="fas fa-times"></i> Cancelar</button>
                  </td> --}}
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>

    @include('shared.ventas.modal_sale_details')

</div>
