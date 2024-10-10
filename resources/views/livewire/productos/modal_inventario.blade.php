<div wire:ignore.self class="modal fade" data-backdrop="static" id="mdlInventario">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="row">
        <div class="col-12">
            <div class="card m-0">
    
                <div class="card-header d-flex p-0">
                    <h3 class="pl-3 pt-3">{{ $producto->codigo . " / " . $producto->descripcion }}</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a wire:click="showInventario({{$id_product_selected}})" class="nav-link" style="cursor: pointer;"><i class="fas fa-long-arrow-alt-left"></i> Regresar</a></li>
                        <li class="nav-item"><a class="nav-link {{ $activeTab == 1 ? 'active' : ''}}" wire:click="$set('activeTab',1)" href="#"><i class="fas fa-search-dollar"></i> Costos</a></li>
                        <li class="nav-item"><a class="nav-link {{ $activeTab == 2 ? 'active' : ''}}" wire:click="$set('activeTab',2)" href="#"><i class="fas fa-sign-in-alt"></i> Entradas</a></li>
                        <li class="nav-item"><a class="nav-link {{ $activeTab == 3 ? 'active' : ''}}" wire:click="$set('activeTab',3)" href="#"><i class="fas fa-sign-out-alt"></i> Salidas</a></li>
                        @if ($inventario->apartados()->count() > 0)
                            <li class="nav-item"><a class="nav-link {{ $activeTab == 4 ? 'active' : ''}}" wire:click="$set('activeTab',4)" href="#"><i class="fas fa-clock"></i> Apartados</a></li>
                        @endif
                        <li class="nav-item"><a data-dismiss="modal" wire:click="cancel" class="nav-link" style="cursor: pointer;"><i class="fas fa-times"></i> Cerrar</a></li>
                    </ul>
                </div>
                
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane {{ $activeTab == 1 ? 'active' : ''}}" id="tab_1">
                            <div class="card m-0">
                                <div class="card-body">
                                    <form>
                                        <br>
                                        <h4>Sucursal: {{ $inventario->sucursal->nombre ?? '' }}</h4>
                                        <br>
                                        <input type="hidden" wire:model="selected_id">
                                        <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="codigo">Mínimo</label>
                                            <input wire:model="inventario.minimo" style="text-transform: uppercase;" type="text" name="minimo"
                                            class="form-control" />
                                            @error('inventario.minimo') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="codigo">Existencia</label>
                                            <input disabled wire:model="inventario.existencia" style="text-transform: uppercase;" type="text" name="existencia"
                                            class="form-control" />
                                            @error('inventario.existencia') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="costo">Costo</label>
                                            <input wire:model="inventario.costo" style="text-transform: uppercase;" type="text" name="costo"
                                            class="form-control" />
                                            @error('inventario.costo') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="codigo">Precio</label>
                                            <input wire:model="inventario.precio" style="text-transform: uppercase;" type="text" name="precio"
                                            class="form-control" />
                                            @error('inventario.precio') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="card-footer">
                                    <button type="button" wire:click.prevent="saveInventario()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Inventario</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane {{ $activeTab == 2 ? 'active' : ''}}" id="tab_2">
                            <div class="card m-0">
                                <div class="card-body p-0" style="min-height: 50vh; max-height: 85vh; overflow: scroll;">
                                    <button wire:click="showMdlIO(true)" class="btn btn-xs btn-success ml-3 mt-3"><i class='fa fa-plus'></i> Registrar Entrada</button>
                                    <table class="table table-striped project">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Usuario</th>
                                                <th>Tipo</th>
                                                <th class="text-center">Cantidad</th>
                                                <th>Comentarios</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventario->entradas() as $item)
                                            <tr>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->usuario->name }}</td>
                                                <td>
                                                    {{ $item->tipo }}
                                                    @if ($item->tipo == 'TRANSFERENCIA')
                                                    <br>
                                                    <small>Desde: {{ $item->emisor->nombre }}</small>
                                                    @endif
                                                </td>
                                                <td class="text-center"><small class="text-success mr-1"><i class='fas fa-arrow-up'></i></small> @qty($item->cantidad)</td>
                                                <td>{{ $item->comentarios }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{$inventario->entradas()->links()}}
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane {{ $activeTab == 3 ? 'active' : ''}}" id="tab_3">
                            <div class="card m-0">
                                <div class="card-body p-0" style="min-height: 50vh; max-height: 85vh; overflow: scroll;">
                                    <button wire:click="showMdlIO(false)" class="btn btn-xs btn-danger ml-3 mt-3"><i class='fa fa-minus'></i> Registrar Salida</button>
                                    
                                    <table class="table table-striped project">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Usuario</th>
                                                <th>Tipo</th>
                                                <th class="text-center">Cantidad</th>
                                                <th>Comentarios</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventario->salidas() as $item)
                                            <tr>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->usuario->name }}</td>
                                                <td>
                                                    {{ $item->tipo }}
                                                    @if ($item->tipo == 'TRANSFERENCIA')
                                                    <br>
                                                    <small>Hacia: {{ $item->emisor->nombre }}</small>
                                                    @endif
                                                </td>
                                                <td class="text-center"><small class="text-danger mr-1"><i class='fas fa-arrow-down'></i></small> @qty($item->cantidad)</td>
                                                <td>{{ $item->comentarios }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{$inventario->salidas()->links()}}
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane {{ $activeTab == 4 ? 'active' : ''}}" id="tab_4">
                            <div class="card m-0">
                                <div class="card-body p-0" style="min-height: 50vh; max-height: 85vh; overflow: scroll;">
                                    <a href="/apartados" target="_blank" class="ml-2 mt-2 btn btn-xs btn-primary"><i class='fa fa-clock'></i> Ver Apartados</a>    
                                    <table class="table table-striped project">
                                        <thead>
                                            <tr>
                                                <th>Folio</th>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Cantidad</th>
                                                <th>Vigencia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventario->apartados() as $item)
                                            <tr>  
                                                <td>{{ $item->id_paddy }}</td>
                                                <td>{{ $item->fecha_format }}</td>
                                                <td>{{ $item->cliente->nombre }}</td>
                                                <td>{{ $item->conceptos->sum('cantidad') }}</td>
                                                <td>{{ $item->vence_format }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
