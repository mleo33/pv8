<div class="row pt-4">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex p-0">
                <h3 class="pl-3 pt-3">{{ $cliente->nombre }}</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a wire:click="cancel" class="nav-link" style="cursor: pointer;"><i class="fas fa-long-arrow-alt-left"></i> Regresar</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 1 ? 'active' : ''}}" wire:click="$set('activeTab',1)" href="#"><i class="fas fa-user-tie"></i> Datos Generales</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 2 ? 'active' : ''}}" wire:click="$set('activeTab',2)" href="#"><i class="fas fa-phone"></i> Teléfonos</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 3 ? 'active' : ''}}" wire:click="$set('activeTab',3)" href="#"><i class="fas fa-users"></i> Referencias</a></li>
                    <li class="nav-item"><a class="nav-link {{ $activeTab == 4 ? 'active' : ''}}" wire:click="$set('activeTab',4)" href="#"><i class="fas fa-file-alt"></i> Datos Fiscales</a></li>
                </ul>
            </div>
            
            <div class="card-body p-0">
                <div class="tab-content">

                    <div class="tab-pane {{ $activeTab == 1 ? 'active' : ''}}" id="tab_1">
                        <div class="card m-0" style="min-height: 65vh;">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="cliente.nombre">Nombre</label>
                                        <input wire:model.defer="cliente.nombre" type="text" name="cliente.nombre" class="form-control" required />
                                        @error('cliente.nombre') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
            
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="cliente.direccion">Dirección</label>
                                        <input wire:model.defer="cliente.direccion" type="text" name="cliente.direccion" class="form-control" required />
                                        @error('cliente.direccion') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                        
                                <div class="form-row">
            
                                    <div class="form-group col-md-6">
                                        <div class="form-group">
                                            <label for="cliente.correo">Correo Electrónico</label>
                                            <input wire:model.defer="cliente.correo" type="email" name="cliente.correo" class="form-control" value="{{ old('cliente.correo') }}" />
                                            @error('cliente.correo') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
            
            
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label for="cliente.limite_credito">Limite de Crédito</label>
                                            <input style="text-align: right;" wire:model.defer="cliente.limite_credito" type="number" name="cliente.limite_credito" class="form-control" value="{{ old('cliente.limite_credito') }}" />
                                            @error('cliente.limite_credito') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <div class="form-group">
                                            <label for="cliente.dias_credito">Dias de Crédito</label>
                                            <input style="text-align: right;" wire:model.defer="cliente.dias_credito" type="number" name="cliente.dias_credito" class="form-control" value="{{ old('cliente.dias_credito') }}" />
                                            @error('cliente.dias_credito') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                        
            
                                </div>
                        
                                <div class="form-group">
                                    <label for="cliente.comentarios">Comentarios</label>
                                    <textarea wire:model.defer="cliente.comentarios" rows="5" name="cliente.comentarios" class="form-control"></textarea>
                                    @error('cliente.comentarios') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <button class="btn btn-primary" wire:click="saveCliente()"><i class="fas fa-save"></i> Guardar datos</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane {{ $activeTab == 2 ? 'active' : ''}}" id="tab_2">
                        <div class="card m-0" style="min-height: 65vh;">
                            <div class="card-body p-0">
                                <button class="m-3 btn btn-sm btn-success" data-toggle="modal" data-target="#mdlTelefono"><i class="fa fa-phone"></i> Agregar Teléfono</button>
                                <table class="table table-hover projects">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo</th>
                                            <th>Número</th>
                                            <th>Notas</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($cliente->telefonos as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->tipo}}</td>
                                            <td>{{$item->numero}}</td>
                                            <td>{{$item->notas}}</td>
                                            <td>
                                                <button wire:click="editTelefono({{$item->id}})" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Editar</button>
                                                <button onclick="destroy('{{ $item->id }}', 'teléfono: {{ $item->numero }}', 'destroyTelefono')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane {{ $activeTab == 3 ? 'active' : ''}}" id="tab_3">
                        <div class="card m-0" style="min-height: 65vh;">
                            <div class="card-body p-0">
                                @if ($this->cliente->referencias->count() < 3)
                                    <button class="m-3 btn btn-sm btn-success" data-toggle="modal" data-target="#mdlReferencia"><i class="fa fa-user"></i> Agregar Referencia</button>                                    
                                @endif
                                <table class="table table-hover projects">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Dirección</th>
                                            <th>Teléfono 1</th>
                                            <th>Teléfono 2</th>
                                            <th>Notas</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($cliente->referencias as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->nombre}}</td>
                                            <td>{{$item->direccion ?? 'NO DEFINIDA'}}</td>
                                            <td>{{$item->telefono1}}</td>
                                            <td>{{$item->telefono2 ?? 'N/A'}}</td>
                                            <td>{{$item->notas}}</td>
                                            <td>
                                                <button wire:click="editReferencia({{$item->id}})" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Editar</button>
                                                <button onclick="destroy('{{ $item->id }}', 'Referencia: {{ $item->nombre }}', 'destroyReferencia')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane {{ $activeTab == 4 ? 'active' : ''}}" id="tab_3">
                        <div class="card m-0" style="min-height: 65vh;">
                            <div class="card-body p-0">
                                <button class="m-3 btn btn-sm btn-success" data-toggle="modal" data-target="#mdlEntidadFiscal"><i class="fa fa-university"></i> Agregar Entidad Fiscal</button>
                                <table class="table table-hover projects">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Razón Social</th>
                                            <th>RFC</th>
                                            <th>Ciudad</th>
                                            <th>Estado</th>
                                            <th>Correo</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($cliente->entidades_fiscales as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->razon_social}}</td>
                                            <td>{{$item->rfc}}</td>
                                            <td>{{$item->ciudad}}</td>
                                            <td>{{$item->estado}}</td>
                                            <td>{{$item->correo}}</td>
                                            <td>
                                                <button wire:click="editEntidadFiscal({{$item->id}})" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Editar</button>
                                                <button onclick="destroy('{{ $item->id }}', 'E. Fiscal: {{ $item->rfc }}', 'destroyEntidadFiscal')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                                            </td>
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

    @include('livewire.clientes.modal_telefono')
    @include('livewire.clientes.modal_entidad_fiscal')
    @include('livewire.clientes.modal_referencia')
</div>