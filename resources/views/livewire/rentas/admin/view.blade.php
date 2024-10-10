<div class="pt-4">
  
  <div class="card">
    <div class="card-header d-flex p-0">
        <h3 class="pl-3 pt-3">Contrato de Arrendamiento #@paddy($renta->id)</h3>
        <ul class="nav nav-pills ml-auto p-2">
          <li class="nav-item"><a class="nav-link {{ $activeTab == 1 ? 'active' : ''}}" wire:click="$set('activeTab',1)" href="#"><i class="fas fa-caravan"></i> Equipos</a></li>
          <li class="nav-item"><a class="nav-link {{ $activeTab == 2 ? 'active' : ''}}" wire:click="$set('activeTab',2)" href="#"><i class="fas fa-user"></i> Cliente</a></li>
          <li class="nav-item"><a class="nav-link {{ $activeTab == 3 ? 'active' : ''}}" wire:click="$set('activeTab',3)" href="#"><i class="fas fa-route"></i> Traslado</a></li>
          <li class="nav-item"><a class="nav-link {{ $activeTab == 4 ? 'active' : ''}}" wire:click="$set('activeTab',4)" href="#"><i class="fas fa-dollar-sign"></i> Pagos</a></li>
          <li class="nav-item"><a class="nav-link {{ $activeTab == 5 ? 'active' : ''}}" wire:click="$set('activeTab',5)" href="#"><i class="fas fa-file-alt"></i> Facturas</a></li>
          <li class="nav-item"><a class="nav-link {{ $activeTab == 6 ? 'active' : ''}}" wire:click="$set('activeTab',6)" href="#"><i class="fas fa-comments"></i> Comentarios</a></li>
        </ul>
    </div>
    
    <div class="card-body p-0">
        <div class="tab-content">

            <!-- /.tab-equipo -->
            <div class="tab-pane {{ $activeTab == 1 ? 'active' : ''}}" id="tab_1">
                <div class="card m-0" style="min-height: 80vh">
                    <div class="card-body p-0">
                      {{-- {{ $renta->equipos }} --}}
                      <h5 class="m-3">
                        Fecha de Renta: {{$this->renta->fecha_format()}}
                        @if ($this->renta->canceled_at)
                          <div style="color: red;">CANCELADO POR: {{$this->renta->cancelado_por->name}} ({{$this->renta->fecha_cancelacion()}})</div>
                        @endif
                      </h5>
                      <div class="row m-2">
                        <div class="col-12 col-md-4">
                          <div class="info-box">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-handshake"></i></span>
            
                            <div class="info-box-content">
                              <span class="info-box-text"><b>Total de Renta</b></span>
                              <span class="info-box-number">@money($this->renta->total())</span>
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
                              <span class="info-box-number">@money($this->renta->ingresos->sum('monto'))</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-md-4">
                          <div class="info-box mb-3">
                            @php
                                $saldo = $this->renta->saldo_pendiente();

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
                              <span class="info-box-number">@money(abs($this->renta->saldo_pendiente()))</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                      </div>
                      {{-- ///// --}}


                      <table class="table table-striped projects">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Recibido</th>
                            <th>FUA</th>
                            <th></th>
                            <th style="width: 30%">Descripción</th>
                            <th>Renta</th>
                            <th>Precio</th>
                            <th>Retorno</th>
                            <th>Sub-Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($this->renta->equipos as $item)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>
                                @if ($this->renta->canceled_at)
                                  <button class="btn btn-danger btn-xs"><i class="fa fa-times"></i> CANCELADO</button>
                                @elseif ($item->fecha_recibido)
                                  <button wire:click="mdlRecibido({{$loop->index}})" class="btn btn-success btn-xs"><i class="fa fa-check"></i> RECIBIDO</button>
                                @else
                                  <label class="content-input">
                                    <input wire:click="mdlHorometro({{$loop->index}})" type="checkbox" wire:model="renta.equipos.{{$loop->index}}.recibido">
                                    <i></i>
                                  </label>
                                @endif
                              </td>
                              <td><button class="btn btn-warning btn-xs pl-3 pr-3"><b>{{ $item->fua }}</b></button></td>
                              <td>
                                @if ($item->unidades > 1)
                                  <button class="btn btn-xs btn-success">X {{$item->unidades}}</button></td>                                    
                                @endif
                              <td>{{ $item->descripcion }}</td>
                              <td>
                                @if ($item->fecha_recibido)
                                <center>
                                  {{ $item->cantidad }} {{$item->tipo_renta }}{{ $item->cantidad > 1 ? ($item->tipo_renta == 'MES' ? 'ES' : 'S') : '' }}
                                </center>
                                @else
                                  <div class="qtyControl">
                                    <button wire:click="addQty({{ $loop->index }},-1)" class="btn btn-warning btn-xs">
                                      <i class="fas fa-minus"></i>
                                    </button>
                                    <button style="width: 60%" wire:click="mdlPrecioRentas({{ $loop->index }})" class="btn btn-default btn-xs"><b class="m-3">
                                      {{ $item->cantidad }} {{$item->tipo_renta }}{{ $item->cantidad > 1 ? ($item->tipo_renta == 'MES' ? 'ES' : 'S') : '' }}</b>
                                    </button>
                                    <button wire:click="addQty({{ $loop->index }},1)" class="btn btn-warning btn-xs">
                                      <i class="fas fa-plus"></i>
                                    </button>
                                  </div>
                                @endif

                              </td>
                              <td>@money($item->precio)</td>
                              @php
                                  if(!$item->fecha_recibido){
                                    $txtColor = now() > $item->fecha_retorno ? 'red' : 'black';                                    
                                  } else {
                                    $txtColor = $item->fecha_recibido > $item->fecha_retorno ? 'red' : 'black';
                                  }
                              @endphp

                              <td style="color: {{$txtColor}}">{{ $item->retorno_format() }}</td>
                              <td>@money($item->importe())</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    
                    @if (!$this->renta->canceled_at)
                      <div class="card-footer">
                        <div class="d-flex justify-content-between">
                          @if ($this->renta->equipos->where('fecha_recibido', null)->count() > 0)
                            <button class="btn btn-primary" wire:click="saveRenta()"><i class="fas fa-save"></i> Guardar datos</button>                              
                          @endif
                          @if ($this->renta->activa())
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#mdlComentarioCancelacion"><i class="fas fa-times"></i> Cancelar Contrato</button>                              
                          @endif
                        </div>
                      </div>  
                    @endif
                    
                </div>
            </div>
            <!-- /.tab-cliente -->
            <div class="tab-pane {{ $activeTab == 2 ? 'active' : ''}}" id="tab_2">
                <div class="card m-0" style="min-height: 80vh">
                    <div class="card-body">
                      <h1>{{$renta->cliente->nombre}}</h1>
                      <h3><b>Calle:</b> {{$renta->cliente->calle}}</h3>
                      <h3><b>Número:</b> {{$renta->cliente->numero}}</h3>
                      @if ($renta->cliente->numero_int)
                        <h3><b>Número Interior:</b> {{$renta->cliente->numero_int}}</h3>
                      @endif
                      <h3><b>Teléfono:</b> {{$renta->cliente->telefono}}</h3>
                      <h3><b>Correo:</b> {{$renta->cliente->correo}}</h3>
                      
                      <br>
                      <a target="_blank" href="/pdf/contrato_renta/{{$renta->id}}" class="btn btn-primary"><i class="fas fa-handshake"></i> Ver Contrato</a>
                      @if ($renta->cliente->rentas_activas->where('id', '!=', $renta->id)->count() > 0)
                        <button class="btn btn-warning"><i class="fas fa-clock"></i> Otras Rentas Pendientes ({{$renta->cliente->rentas_activas->where('id', '!=', $renta->id)->count()}})</button>
                      @endif
                    </div>
                </div>
            </div>
            <!-- /.tab-traslados -->
            <div class="tab-pane {{ $activeTab == 3 ? 'active' : ''}}" id="tab_3">
                <div class="card m-0" style="min-height: 80vh">
                    <div class="card-body p-0">
                      <table class="table table-striped projects">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Destino</th>
                            <th>Viaje</th>
                            <th>Costo</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($this->renta->traslados as $item)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $item->descripcion }}</td>
                              <td>{{ $item->tipo_renta }}</td>
                              <td>@money($item->importe())</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    
                    <div class="card-footer">
                        
                    </div>
                </div>
            </div>
            <!-- /.tab-pagos -->
            <div class="tab-pane {{ $activeTab == 4 ? 'active' : ''}}" id="tab_4">
              <div class="card m-0" style="min-height: 80vh">
                  <div class="card-body p-0">
                    @if ($this->renta->activa())
                      <button wire:click="mdlPago" class="btn btn-sm btn-success m-2"><i class="fas fa-dollar-sign"></i> Registrar Pago</button>
                    @endif
                    <table class="table table-striped projects">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Fecha</th>
                          <th>Usuario</th>
                          <th>Tipo</th>
                          <th>Forma de Pago</th>
                          <th>Monto</th>
                          <th>Imprimir Ticket</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($renta->ingresos as $item)
                          <tr @if ($item->canceled_at) style="color:red;" @endif>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $item->fecha_format() }}</td>
                            <td>{{ $item->usuario->name }}</td>
                            <td>{{ $item->tipo }}</td>
                            <td>{{ $item->forma_pago }}</td>
                            <td>
                              @money($item->monto)
                            </td>
                            <td>
                              @if ($item->canceled_by)
                                <button wire:click="mdlCancelBy({{$item}})" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> PAGO CANCELADO</button>
                              @else
                                <button wire:click="imprimirTicketAbono({{$item->id}})" class="btn btn-primary btn-xs"><i class="fa fa-print"></i> Imprimir Ticket</button>
                              @endif
                            </td>

                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  
                  <div class="card-footer">
                  </div>
              </div>
            </div>
            <!-- /.tab-facturas -->
            <div class="tab-pane {{ $activeTab == 5 ? 'active' : ''}}" id="tab_5">
              <div class="card m-0" style="min-height: 80vh">
                  <div class="card-body p-0">
                    <table class="table table-striped projects">
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
                          <th>PDF</th>
                          {{-- <th>Cancelar</th> --}}
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($renta->facturas as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at->format('m/d/Y h:i A') }}</td>
                            <td> @paddy($item->id) </td>
                            <td>{{ $item->usuario->name }}</td>
                            <td>{{ $item->entidad_fiscal->razon_social}}</td>
                            <td>{{ $item->estatus }}</td>
                            <td> @money($item->subtotal) </td>
                            <td> @money($item->total) </td>
          
          
                            {{-- <td><button wire:click="viewRegistros({{$item->id}})" class="btn btn-sm btn-primary"><i class="fas fa-shopping-basket"></i> <b>{{ $item->totalProductos() }}</b></button></td>
                            <td>@money($item->total())</td> --}}
                            <td>
                              <a class="btn btn-xs btn-primary" href="/facturacion/ver_pdf/{{$item->id}}" target="_blank"><i class="fas fa-file-pdf"></i> Ver PDF</a>
                            </td>
                            {{-- <td>
                              <button class="btn btn-xs btn-danger" onclick="destroy('{{ $item->id }}', 'venta: {{ $item->id }}')"><i class="fas fa-times"></i> Cancelar</button>
                            </td> --}}
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  
                  <div class="card-footer">
                  </div>
              </div>
            </div>
            <!-- /.tab-comentarios -->
            <div class="tab-pane {{ $activeTab == 6 ? 'active' : ''}}" id="tab_4">
              <div class="card m-0" style="min-height: 80vh">
                  <div class="card-body p-0">
                    @if ($this->renta->activa())
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
                        @foreach($this->renta->comentarios ?? [] as $elem)
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

          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>
  </div>
  
  @include('livewire.rentas.admin.partials.modal_horometro')
  @include('livewire.rentas.admin.partials.modal_pago')
  @if (isset($this->regIndex))
    @include('livewire.rentas.admin.partials.modal_precios_renta', ['equipo' => $this->renta->equipos[$this->regIndex]->model])
  @endif
  
  @include('shared.general.modal_comentarios')

  @include('shared.general.modal_comentario_cancelacion', ['title' => 'Cancelar Contrato'])

  @if (isset($this->regIndex) && isset($this->renta->equipos[$this->regIndex]->fecha_recibido))
    @include('livewire.rentas.admin.partials.modal_recibido', ['equipo' => $this->renta->equipos[$this->regIndex]->model])    
  @endif

  @if ($this->cancelItem)
      @include('shared.general.modal_canceled_by', ['item' => $this->cancelItem])
  @endif
  
</div>

