<div class="row pt-4">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex p-0">
                <h3 class="pl-3 pt-3">{{ $usuario->name }}</h3>
                <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a wire:click="edit(0)" class="nav-link" style="cursor: pointer;"><i class="fas fa-long-arrow-alt-left"></i> Regresar</a></li>
                <li class="nav-item"><a class="nav-link {{ $activeTab == 1 ? 'active' : ''}}" wire:click="$set('activeTab',1)" href="#"><i class="fas fa-user-tie"></i> Datos Generales</a></li>
                <li class="nav-item"><a class="nav-link {{ $activeTab == 2 ? 'active' : ''}}" wire:click="$set('activeTab',2)" href="#"><i class="fas fa-store"></i> Sucursales ({{$this->usuario->sucursales->count() }})</a></li>
                <li class="nav-item"><a class="nav-link {{ $activeTab == 3 ? 'active' : ''}}" wire:click="$set('activeTab',3)" href="#"><i class="fas fa-user-shield"></i> Roles ({{$this->usuario->roles->count() }})</a></li>
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                    Opciones <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" tabindex="-1" href="#">Deshabilitar</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" tabindex="-1" href="#">Eliminar</a>
                    </div>
                </li> --}}
                </ul>
            </div>
            
            <div class="card-body p-0">
                <div class="tab-content">
                    <div class="tab-pane {{ $activeTab == 1 ? 'active' : ''}}" id="tab_1">
                        <div class="card m-0">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                    <label for="usuario.name">Nombre</label>
                                    <input wire:model="usuario.name" type="text" name="usuario.name" class="form-control" />
                                    @error('usuario.name') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                    
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                    <label for="usuario.email">Correo</label>
                                    <input wire:model="usuario.email" type="text" name="usuario.email" class="form-control" />
                                    @error('usuario.email') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <button class="btn btn-primary" wire:click="saveUser()"><i class="fas fa-save"></i> Guardar datos</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane {{ $activeTab == 2 ? 'active' : ''}}" id="tab_2">
                        <div class="card m-0">
                            <div class="card-body p-0">
                                <table class="table table-striped project">
                                    <thead>
                                        <tr>
                                            <th>Acceso</th>
                                            <th>Nombre</th>
                                            <th>Dirección</th>
                                            <th>Teléfono</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($catalogo_sucursales as $sucursal)
                                        <tr>
                                            <td>
                                                <label class="content-input">
                                                    <input type="checkbox" wire:model="sucursales.{{$loop->index}}" value="{{ $sucursal->id }}"/>
                                                    <i></i>
                                                </label>
                                            </td>   
                                            <td>{{ $sucursal->nombre }}</td>
                                            <td>{{ $sucursal->direccion }}</td>
                                            <td>{{ $sucursal->telefono }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="card-footer">
                                <button class="btn btn-primary" wire:click="saveSucursales()"><i class="fas fa-store"></i> Guardar Sucursales</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane {{ $activeTab == 3 ? 'active' : ''}}" id="tab_3">
                        <div class="card m-0">
                            <div class="card-body p-0">
                                <table class="table table-hover projects">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Asignar Rol</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($catalogo_roles as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ Str::upper(str_replace('-', ' ', $row->name)) }}</td>
                                            <td>
                                            <label class="content-input">
                                                <input type="checkbox" wire:model="roles.{{$loop->index}}" value="{{ $row->id }}"/>
                                                <i></i>
                                            </label>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="card-footer">
                                <button class="btn btn-primary" wire:click="saveRoles()"><i class="fas fa-shield-alt"></i> Guardar Roles</button>
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