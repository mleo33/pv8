<div class="card">
    <div class="card-header">
        @if (isset($cliente))
            <a target="_blank" href="/clientes/{{$cliente->id}}" class="btn btn-sm btn-primary"><i class="fas fa-user"></i> Cliente #{{ $cliente->id_paddy }}</a>
        @else
            <h3 class="card-title font-weight-bold"><i class="fas fa-user"></i> Cliente</h3>
        @endif
        <div class="card-tools">


            @if (isset($cliente))
                
                <button class="btn btn-xs btn-danger" wire:click="setCliente(0)"><i class="fas fa-minus"></i> <i
                        class="fas fa-user"></i> Remover Cliente</button>
            @else
                <button class="btn btn-xs btn-primary" wire:click="$emit('initMdlSelectCliente')"><i
                        class="fas fa-plus"></i><i class="fas fa-user"></i> Agregar Cliente</button>
            @endif

            @if ($showFacturacionControl ?? false)
                @if (!$this->factura_t->model_id)
                    <button data-toggle="modal" data-target="#mdlSelectVenta" class="btn btn-xs btn-primary"><i class="fas fa-shopping-basket"></i> Seleccionar Venta</button>
                @elseif ($this->factura_t->model_type == 'App\\Models\\Venta')
                    <a href="/venta/{{$this->factura_t->model_id}}" target="_blank" class="btn btn-xs btn-primary"><i class="fas fa-shopping-basket"></i> Venta #@paddy($this->factura_t->model_id)</a>
                @elseif ($this->factura_t->model_type == 'App\\Models\\Renta')
                    <a href="/administrar_renta/{{$this->factura_t->model_id}}" target="_blank" class="btn btn-xs btn-warning"><i class="fas fa-handshake"></i> Renta #@paddy($this->factura_t->model_id)</a>
                @endif
            @endif
        </div>
    </div>

    <div class="card-body p-3" style="min-height: 25vh">

        <div class="row">


    
            <div class="col">
                @if (isset($cliente))
                    <h6><b>Nombre: </b>{{ $cliente->nombre }}</h6>
                    <h6><b>Dirección: </b>{{ $cliente->direccion }}</h6>
                    @if ($cliente->correo)
                        <h6><b>Correo: </b>{{ $cliente->correo }}</h6>
                    @endif
    
                    @if ($cliente->limite_credito > 0)
                        <h6><b>Limite de Crédito: </b>@money($cliente->limite_credito)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Crédito
                                Disponible: </b>@money($cliente->credito_disponible())</h6>
                    @endif
    
                    @if (isset($entidad_fiscal))
                        <h6><b>RFC: </b>{{ $entidad_fiscal->rfc }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Razón Social:
                            </b>{{ $entidad_fiscal->razon_social }}</h6>
                    @endif
    
                    @if ($showEntidadesFiscales ?? true)
                        @if ($cliente->entidades_fiscales->count() > 1)
                            <button wire:click='mdlEntidadesFiscales' class="btn btn-xs btn-primary"><i
                                    class="fa fa-university"></i> Seleccionar RFC</button>
                        @elseif ($cliente->entidades_fiscales->count() == 0)
                            <p style="color: red;">Cliente no tiene RFC's registrados</p>
                        @endif
                    @endif
    
                    @if ($showRentasActivas ?? true)
                        @if ($cliente->rentas_activas->count() > 0)
                            <button data-toggle="modal" data-target="#mdlActiveRents" class="btn btn-warning btn-xs"><i
                                    class="fas fa-clock"></i> Rentas Activas
                                ({{ $cliente->rentas_activas->count() }})</button>
                        @endif
                    @endif
                @else
                    <center>
                        <h3 style="cursor: pointer" wire:click="$emit('initMdlSelectCliente')">Seleccione cliente</h3>
                    </center>
                    <br>
                @endif
    
                @if ($showVigencia ?? false)
                    <h6><b>Vigencia: </b></h6>
                    <input wire:model='cotizacion_t.vigencia' wire:change="saveComment" style="width: 40%;"
                        class="form-control" type="date">
                @endif
    
                @if ($showFechaRenta ?? false)
                    <div class="row">
                        <div class="col">
                            
                            <div class="mt-2">
                                <h6><b>Fecha Renta: </b></h6>
                                <input wire:model='renta_t.fecha_renta' style="width: 70%;" class="form-control"
                                    type="date">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mt-2">
                                <label for="renta_t.incluye_iva">Incluir IVA</label>
                                <label class="content-input">
                                    <input wire:change="toggleIva" type="checkbox" wire:model="renta_t.incluye_iva" />
                                    <i></i>
                                </label>
                            </div>
                        </div>
                    </div>
                @endif
    
                @if ($showFacturacionControl ?? false)
                    <div class="row">
                        <div class="col">
                            <h6><b>Forma Pago: </b></h6>
                            <select wire:model.defer="factura_t.forma_pago" wire:change="saveFactura" class="form-control">
                                <option></option>
                                @foreach ($this->formas_pago as $key => $value)
                                    <option value="{{ $key }}">{{ $key }} - {{ $value }}</option>
                                @endforeach
                            </select>
                            @error('factura_t.forma_pago')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col">
                            <h6><b>Método de Pago: </b></h6>
                            <select wire:model.defer="factura_t.metodo_pago" wire:change="saveFactura" class="form-control">
                                <option></option>
                                @foreach ($this->metodos_pago as $key => $value)
                                    <option value="{{ $key }}">{{ $key }} - {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('factura_t.metodo_pago')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col">
                            <h6><b>Uso CFDI: </b></h6>
                            <select wire:model.defer="factura_t.uso_cfdi" wire:change="saveFactura" class="form-control">
                                <option></option>
                                @foreach ($this->uso_cfdi as $key => $value)
                                    <option value="{{ $key }}">{{ $key }} - {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('factura_t.uso_cfdi')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col">
                            <h6><b>Desglosar IVA</b></h6>
                            <div class="col-12 col-md-6">
                              <label class="content-input">
                                <input type="checkbox" wire:model="factura_t.desglosar_iva" wire:change="desglosarIvaToggle"/>
                                <i></i>
                              </label>
                            </div>
                        </div>
                    </div>
    
    
                @endif

                @if (isset($entidad_fiscal) && $entidad_fiscal->rfc == 'XAXX010101000')
                    <div class="row">
                        <div class="col-3">
                            <h6><b>Periodicidad: </b></h6>
                            <select wire:model.defer="periocidad" class="form-control">
                                <option></option>
                                <option value="01">Diario</option>
                                <option value="02">Semanal</option>
                                <option value="03">Quincenal</option>
                                <option value="04">Mensual</option>
                                <option value="05">Bimestral</option>
                            </select>
                            @error('periocidad')
                                <span class="error text-danger">Campo requerido</span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <h6><b>Meses: </b></h6>
                            <select wire:model.defer="meses" class="form-control">
                                <option></option>
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                                <option value="13">Enero-Febrero</option>
                                <option value="14">Marzo-Abril</option>
                                <option value="15">Mayo-Junio</option>
                                <option value="16">Julio-Agosto</option>
                                <option value="17">Septiembre-Octubre</option>
                                <option value="18">Noviembre-Diciembre</option>
                            </select>
                            @error('meses')
                                <span class="error text-danger">Campo requerido</span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <h6><b>Año: </b></h6>
                            <input wire:model.defer="anio" class="form-control" type="text">
                            @error('anio')
                                <span class="error text-danger">Campo requerido</span>
                            @enderror
                        </div>
                    </div>
                @endif
            </div>

            @if ($showFacturacionControl)
                <div class="col-4">
                    @include('livewire.facturas.crear_factura.partials.total2')
                </div>
            @endif
        </div>




    </div>
</div>
