<div class="tab-pane {{ $activeTab == 1 ? 'active' : ''}}" id="tab_1">
    <div class="card m-0" style="min-height: 80vh">
        <div class="card-body p-0">
          {{-- {{ $venta->equipos }} --}}
          <h5 class="m-3">
            Fecha de Venta: {{$this->venta->fecha_format()}}
            @if ($this->venta->canceled_at)
              <div style="color: red;">CANCELADO POR: {{$this->venta->cancelado_por->name}} ({{$this->venta->fecha_cancelacion()}})</div>
            @endif
          </h5>
          <div class="row m-2">
            <div class="col-12 col-md-4">
              <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text"><b>Total de Venta</b></span>
                  <span class="info-box-number">@money($this->venta->total())</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-md-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text"><b>Pagado</b></span>
                  <span class="info-box-number">@money($this->venta->pagado)</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-md-4">
              <div class="info-box mb-3">
                @php
                    $saldo = $this->venta->saldo;

                    $icon = $saldo == 0 ? 'check' : 'clock';
                    $icon = $saldo < 0 ? 'exchange-alt' : $icon;

                    $color = $saldo == 0 ? 'success' : 'warning';
                    $color = $saldo < 0 ? 'info' : $color;

                    $label = $saldo == 0 ? 'Cuenta al corriente' : 'Saldo Pendiente';
                    $label = $saldo < 0 ? 'Saldo a Favor' : $label;
                @endphp
                <span class="info-box-icon bg-{{$color}} elevation-1"><i class="fas fa-{{$icon}}"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text"><b>{{$label}}</b></span>
                  <span class="info-box-number">@money(abs($saldo))</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>

          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Código</th>
                <th style="width: 30%">Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Importe</th>
                <th>Devolución</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($this->venta->registros as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->codigo }}</td>
                  <td>{{ $item->descripcion }}</td>
                  <td>{{ $item->cantidad }}</td>
                  <td>@money($item->precio)</td>
                  <td>@money($item->importe())</td>
                  <td>
                    @if ($item->cantidad > 0 && $item->can_return)
                      <livewire:devolucion.common.btn-devolucion :concepto="$item" :wire:key="'mdl-devolucion-'.$item->id" /></td>
                    @else
                      N/A
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
        @if (!$this->venta->canceled_at)
          <div class="card-footer">
            <div class="d-flex justify-content-between">
              {{-- @if (true)
                <button class="btn btn-primary" wire:click="saveRenta()"><i class="fas fa-save"></i> Guardar datos</button>                              
              @endif --}}
              @if ($this->venta->active)
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#mdlComentarioCancelacion"><i class="fas fa-times"></i> Cancelar Venta</button>                              
              @endif
            </div>
          </div>  
        @endif
        
    </div>
</div>