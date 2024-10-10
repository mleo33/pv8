<div class="pt-4">

    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Egresos</h3>
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
                  <span class="info-box-number">@money($egresos->where('forma_pago', 'EFECTIVO')->sum('monto'))</span>
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
                      $tarjetas = $egresos->where('forma_pago', 'TARJETA DEBITO')->sum('monto');
                      $tarjetas += $egresos->where('forma_pago', 'TARJETA CREDITO')->sum('monto');
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
                  <span class="info-box-number">@money($egresos->where('forma_pago', 'TRANSFERENCIA')->sum('monto'))</span>
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
                  <span class="info-box-number">@money($egresos->sum('monto'))</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>

          <button wire:click="mdlEgreso" class="btn btn-sm btn-danger m-2"><i class="fas fa-hand-holding-usd"></i> Registrar Egreso</button>
          <table class="table table-striped projects">
            <thead>
              <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Usuario</th>
                {{-- <th>Tipo</th> --}}
                <th>Concepto</th>
                <th>Forma de Pago</th>
                <th>Monto</th>
              </tr>
            </thead>
            <tbody>
              @foreach($egresos as $item)
                <tr>
                  <td>{{$loop->iteration}}</td>
				          <td>{{ $item->created_at->format('M/d/Y h:i A') }}</td>
                  <td>{{ $item->usuario->name }}</td>
                  {{-- <td>{{ $item->tipo }}</td> --}}
                  <td>{{ $item->concepto }}</td>
                  <td>{{ $item->forma_pago }}</td>
                  <td>@money($item->monto)</td>
              @endforeach
            </tbody>
          </table>
          
        </div>
        
        <!-- /.card-body -->
    </div>

    @include('shared.egresos.modal_egreso')
</div>
