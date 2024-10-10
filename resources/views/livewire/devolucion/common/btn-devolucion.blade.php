<div class="d-inline">
    <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{$this->modalName}}">
        <i class='fa fa-redo'></i> Devolver
    </button>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->modalName}}">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Devolver: {{$concepto->descripcion}}</h5>
                    <button type="button" class="close" data-toggle="modal" data-target="#{{$this->modalName}}" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="height: 100vh" class="modal-body p-0">

                    @php
                        $color_resto = 'success';
                        $msj_resto = 'Disponible (No reembolsable)';

                        if($this->diferenciaAPagar() > 0){
                            $color_resto = 'warning';
                            $msj_resto = 'Diferencia a Cubrir';
                        }

                    @endphp

                    <div class="row p-2 sticky-top">
                        <div class="col">
                            <div class="info-box">
                                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text"><b>Importe de devolución</b></span>
                                  <span class="info-box-number">@money($this->importeDevolucion())</span>
                                </div>
                            </div>
                        </div>
    
                        <div class="col">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text"><b>Importe Seleccionado</b></span>
                                  <span class="info-box-number">@money($this->importeSeleccionado())</span>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="info-box">
                                <span class="info-box-icon bg-{{$color_resto}} elevation-1"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text"><b>{{$msj_resto}}</b></span>
                                  <span class="info-box-number">@money(abs($this->diferenciaAPagar()))</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="ml-2 pb-2">
                                <label class="mr-2">Cantidad a devolver (Max: {{$this->concepto->cantidad}})</label>
                                <div class="mr-2" style="width: 100px;">
                                    <x-input-number model="cantidadDevolucion" />
                                </div>
                                @error('cantidadDevolucion')<span class="error text-danger">{{$message}}</span>@enderror
                            </div>
                        </div>

                        <div class="col-9">
                            <div class="mr-2 pb-2">
                                <label>Seleccione productos de cambio</label>
                                <input type="text" wire:model.lazy="keyWord" class="form-control" placeholder="Busqueda">
                            </div>
                        </div>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Selecc.</th>
                                <th>Código</th>
                                <th>Marca</th>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th width="150px">Cant.</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($productos as $item)
                        <tboby>
                            @if($item->current_inventory)
                            <tr>
                                <td><x-input-checkbox model='selectedProducts.{{$item->id}}.selected' :value="$item->current_inventory->precio" /></td>
                                <td>{{$item->codigo}}</td>
                                <td>{{$item->marca}}</td>
                                <td>{{$item->descripcion}}</td>
                                <td>@money($item->current_inventory->precio)</td>
                                @if ($this->selectedProducts[$item->id]['selected'] ?? false)
                                    <td>
                                        <x-input-number model='selectedProducts.{{$item->id}}.cantidad' />
                                        @error("selectedProducts.$item->id.cantidad") <span class="error text-danger">El campo cantidad deber ser al menos 1</span> @enderror
                                    </td>
                                @else
                                    <td>N/A</td>
                                @endif

                            </tr>
                            @endif
                        </tboby>
                        @endforeach
                        </tbody>
                    </table>
                    {{$productos->links()}}
                </div>
                <div class="modal-footer justify-content-between">
                    <button data-toggle="modal" data-target="#{{$this->modalName}}" type="button" class="btn btn-secondary"><i class="fas fa-window-close"></i> Cerrar</button>
                    @if ($this->showBtnDevolucion())
                        <button wire:click="generarDevolucion" class="btn btn-sm btn-warning"><i class="fa fa-redo"></i> Realizar Cambio</button>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    <div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->modalPayment}}">
        <div class="modal-dialog modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pagar: @money($this->diferenciaAPagar())</h5>
                    <button type="button" class="close" data-toggle="modal" data-target="#{{$this->modalPayment}}" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                            <th></th>
                            <th width="50%">Forma de Pago</th>
                            <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                              @foreach ($this->formas_pago as $key => $elem)
                                  
                              <tr>
                                  <td>
                                      @if (!$loop->first)
                                          <button wire:click="removeFormaPago({{ $loop->index }})" class='btn btn-danger btn-xs'>
                                              <i class="fas fa-minus"></i>
                                          </button>
                                      @endif
                                  </td>
                                  <td>
                                      <select wire:model='formas_pago.{{ $key }}.forma' class="form-control">
                                          <option wire:key="{{ $key . $elem['forma'] }}" value="{{  $elem['forma'] }}">{{  $elem['forma'] }}</option>
                                          @foreach ($this->formasPagoRestantes() as $f)
                                          <option wire:key="{{ $key . $f }}" value="{{ $f }}">{{ $f }}</option>
                                          @endforeach
                                      </select>
                                  </td>
                                  <td>
                                      <input onclick="this.select()" style="text-align: right;" type="text" onkeypress="return event.charCode >= 46 && event.charCode <= 57" class="form-control formaPago"
                                      wire:model='formas_pago.{{ $loop->index }}.monto' autofocus />
                                  </td>
                              </tr>
                              @endforeach
                        </tbody>
                    </table>
      
                    <div class="d-flex justify-content-between">
                        @if (count($this->formasPagoRestantes()) > 0)
                        <button wire:click="addFormaPago()" class="btn btn-xs btn-primary"><i class="fas fa-plus"></i> Pago con
                            varias formas</button>
                        @endif
                    </div>
      
                    <br>
                    <center>
                        <?php
                          $pagosCount = count($formas_pago);
                          $montoTotal = 0;
                          foreach ($formas_pago as $elem) {
                              $elem['monto'] = $elem['monto'] ? $elem['monto'] : 0; 
                              $montoTotal += $elem['monto'];
                          }
                          $cambio = $montoTotal - $this->diferenciaAPagar();
                          $mensaje = 'Faltan';
                          if($pagosCount == 1){
                              $mensaje = $cambio > 0 ? 'Cambio':'Faltan';
                          }
                          else{
                              $mensaje = $cambio > 0 ? 'Sobran':'Faltan';
                          }
                        ?>
                        <h2>{{ $mensaje }} @money(abs($cambio))</h2>
                    </center>
                </div>
      
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
                  @php
                      if($pagosCount == 1){                
                          $disabled = $cambio < 0;
                          $color = $cambio < 0 ? 'danger' : 'success';
                          $txt = $cambio < 0 ? 'Saldo Pendiente' : 'PROCESAR PAGO';
                          $icon = $cambio < 0 ? 'fa-times-circle' : 'fa-dollar-sign';
                      } else {
                          $disabled = $cambio != 0;
                          $btnMensaje = $cambio > 0 ? 'Monto Excede' : 'Saldo Pendiente ';
                          $color = $cambio != 0 ? 'danger' : 'success';
                          $txt = $cambio != 0 ? $btnMensaje : 'PROCESAR PAGO';
                          $icon = $cambio != 0 ? 'fa-times-circle' : 'fa-dollar-sign';
                      }
                  @endphp
                  <button type="button" wire:click="createDevolucion()" class="btn btn-{{$color}}" @if($disabled) disabled @endif><i class="fas {{$icon}}"></i> {{$txt}}</button>
                </div>
            </div>
            
        </div>
    </div>
</div>