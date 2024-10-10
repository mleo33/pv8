@section('title', __('Corte de Caja'))
<div class="p-3">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Corte de Caja</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="d-flex justify-content-between mt-3">
            {{-- <h3 class="ml-3">DM</h3> --}}
            <h4 class="ml-2">Ingresos: @money($this->ingresos->sum('monto'))</h4>
          </div>
          <table class="table table-striped projects">
            <thead>
              <tr>
                <th></th>
                <th>EFECTIVO</th>
                <th>CHEQUES</th>
                <th>TRANSFERENCIAS</th>
                <th>T. DEBITO</th>
                <th>T. CREDITO</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>VENTAS</td>
                <td>@money($this->i_ventas->where('forma_pago', 'EFECTIVO')->sum('monto'))</td>
                <td>@money($this->i_ventas->where('forma_pago', 'CHEQUE')->sum('monto'))</td>
                <td>@money($this->i_ventas->where('forma_pago', 'TRANSFERENCIA')->sum('monto'))</td>
                <td>@money($this->i_ventas->where('forma_pago', 'TARJETA DEBITO')->sum('monto'))</td>
                <td>@money($this->i_ventas->where('forma_pago', 'TARJETA CREDITO')->sum('monto'))</td>
              </tr>
              <tr>
                <td>RENTAS</td>
                <td>@money($this->i_rentas->where('tipo', 'ANTICIPO')->where('forma_pago', 'EFECTIVO')->sum('monto'))</td>
                <td>@money($this->i_rentas->where('tipo', 'ANTICIPO')->where('forma_pago', 'CHEQUE')->sum('monto'))</td>
                <td>@money($this->i_rentas->where('tipo', 'ANTICIPO')->where('forma_pago', 'TRANSFERENCIA')->sum('monto'))</td>
                <td>@money($this->i_rentas->where('tipo', 'ANTICIPO')->where('forma_pago', 'TARJETA DEBITO')->sum('monto'))</td>
                <td>@money($this->i_rentas->where('tipo', 'ANTICIPO')->where('forma_pago', 'TARJETA CREDITO')->sum('monto'))</td>
              </tr>
              <tr>
                <td>ABONOS</td>
                <td>@money($this->i_rentas->where('tipo', 'ABONO')->where('forma_pago', 'EFECTIVO')->sum('monto'))</td>
                <td>@money($this->i_rentas->where('tipo', 'ABONO')->where('forma_pago', 'CHEQUE')->sum('monto'))</td>
                <td>@money($this->i_rentas->where('tipo', 'ABONO')->where('forma_pago', 'TRANSFERENCIA')->sum('monto'))</td>
                <td>@money($this->i_rentas->where('tipo', 'ABONO')->where('forma_pago', 'TARJETA DEBITO')->sum('monto'))</td>
                <td>@money($this->i_rentas->where('tipo', 'ABONO')->where('forma_pago', 'TARJETA CREDITO')->sum('monto'))</td>
              </tr>

              <tr>
                <td><b>TOTAL</b></td>
                <td>@money($this->ingresos->where('forma_pago', 'EFECTIVO')->sum('monto'))</td>
                <td>@money($this->ingresos->where('forma_pago', 'CHEQUE')->sum('monto'))</td>
                <td>@money($this->ingresos->where('forma_pago', 'TRANSFERENCIA')->sum('monto'))</td>
                <td>@money($this->ingresos->where('forma_pago', 'TARJETA DEBITO')->sum('monto'))</td>
                <td>@money($this->ingresos->where('forma_pago', 'TARJETA CREDITO')->sum('monto'))</td>
              </tr>

            </tbody>
          </table>


          <br><br>
          <div class="d-flex justify-content-between mt-3">
            {{-- <h3 class="ml-3">DM</h3> --}}
            <h4 class="ml-2">Egresos: @money($this->egresos->sum('monto'))</h4>
          </div>
          <table class="table table-striped projects">
            <thead>
              <tr>
                <th></th>
                <th>EFECTIVO</th>
                <th>CHEQUES</th>
                <th>TRANSFERENCIAS</th>
                <th>T. DEBITO</th>
                <th>T. CREDITO</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Egresos</td>
                <td>@money($this->egresos->where('forma_pago', 'EFECTIVO')->sum('monto'))</td>
                <td>@money($this->egresos->where('forma_pago', 'CHEQUE')->sum('monto'))</td>
                <td>@money($this->egresos->where('forma_pago', 'TRANSFERENCIA')->sum('monto'))</td>
                <td>@money($this->egresos->where('forma_pago', 'TARJETA DEBITO')->sum('monto'))</td>
                <td>@money($this->egresos->where('forma_pago', 'TARJETA CREDITO')->sum('monto'))</td>
              </tr>
            </tbody>
          </table>

          <br><br>
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
              @foreach($this->egresos as $item)
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

          

          {{-- <div class="d-flex justify-content-between mt-5">
            <h3 class="ml-3">G3</h3>
            <h4 class="mr-5">TOTAL: @money(1454454874)</h4>
          </div>

          <table class="table table-striped projects">
            <thead>
              <tr>
                <th></th>
                <th>EFECTIVO</th>
                <th>CHEQUES</th>
                <th>TRANSFERENCIAS</th>
                <th>T. DEBITO</th>
                <th>T. CREDITO</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>RENTAS</td>
                <td>@money(500)</td>
                <td>@money(500)</td>
                <td>@money(500)</td>
                <td>@money(500)</td>
                <td>@money(500)</td>
              </tr>

              <tr>
                <td>ABONOS</td>
                <td>@money(500)</td>
                <td>@money(500)</td>
                <td>@money(500)</td>
                <td>@money(500)</td>
                <td>@money(500)</td>
              </tr>

              <tr>
                <td><b>TOTAL</b></td>
                <td><b>@money(500)</b></td>
                <td><b>@money(500)</b></td>
                <td><b>@money(500)</b></td>
                <td><b>@money(500)</b></td>
                <td><b>@money(500)</b></td>
              </tr>

            </tbody>
          </table>

          <center class="m-5">
            <h1>TOTAL: @money(15400)</h1>
          </center> --}}
          
        </div>
        
        <!-- /.card-body -->
    </div>
</div>