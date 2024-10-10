<div class="tab-pane {{ $activeTab == 2 ? 'active' : ''}}" id="tab_2">
  <div class="card m-0" style="min-height: 80vh">
      <div class="card-body">
        <h1>{{$venta->cliente->nombre}}</h1>
        <h5><b>Dirección:</b> {{$this->venta->cliente->direccion}}</h5>
        <h5><b>Correo:</b> {{$this->venta->cliente->correo}}</h5>
        <h5><b>Limite de Crédito:</b> @money($this->venta->cliente->limite_credito)</h5>
        
        @if($this->venta->cliente->comentarios)
        <br>
        <h5><b>Comentarios:</b> {{$this->venta->cliente->comentarios}}</h5>
        @endif
        
        <br>
        @if ($venta->cliente->entidades_fiscales->count() > 0)
          <h5><b>Entidades Fiscales</b></h5>
          <table class="table table-striped projects">
            <thead>
              <tr>
                <th>#</th>
                <th>RFC</th>
                <th>Razón Social</th>
                <th>Dirección</th>
                <th>Ciuad</th>
                <th>Estado</th>
                <th>Correo</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($venta->cliente->entidades_fiscales as $item)           
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->rfc }}</td>
                <td>{{ $item->razon_social }}</td>
                <td>{{ $item->direccion }}</td>
                <td>{{ $item->ciudad }}</td>
                <td>{{ $item->estado }}</td>
                <td>{{ $item->correo }}</td>
              </tr>          
              @endforeach
            </tbody>
            
          </table>
        @endif

        <br>
        <br>
        @if ($venta->cliente->ventas_pendientes->count() > 0)
          <h5><b>Ventas Pendientes</b></h5>
          <table class="table table-striped projects">
            <thead>
              <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Vendedor</th>
                <th>Cliente</th>
                <th>Productos</th>
                <th>Monto</th>
                <th>Ver Venta</th>
              </tr>
            </thead>
            <tbody>
              @foreach($venta->cliente->ventas_pendientes as $item)
                <tr>
                  <td><a class="btn btn-default" href="aosprint:ticket_venta#{{$item->id}}"> @paddy($item->id) </a></td>
				          <td>{{ $item->created_at->format('m/d/Y h:i A') }}</td>
                  <td>{{ $item->usuario->name }}</td>
                  <td>{{ $item->cliente->nombre ?? 'NO IDENTIFICADO' }}</td>
                  <td><button wire:click="viewRegistros({{$item->id}})" class="btn btn-sm btn-primary"><i class="fas fa-shopping-basket"></i> <b>{{ $item->totalProductos() }}</b></button></td>
                  <td>@money($item->total())</td>
                  <td>
                    <a href="/venta/{{$item->id}}" target="_blank" class="btn btn-sm btn-primary" ><i class="fas fa-shopping-cart"></i> Ver Venta</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif

        
        <br>
        {{-- <a target="_blank" href="/pdf/contrato_venta/{{$venta->id}}" class="btn btn-primary"><i class="fas fa-handshake"></i> Ver Contrato</a> --}}
      </div>
  </div>
</div>