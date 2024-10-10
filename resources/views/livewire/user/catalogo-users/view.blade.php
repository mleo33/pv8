@section('title', __("Usuarios"))
<div class="pt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Catalogo de Usuarios</h3>
        </div>
        <div class="card-body p-0">
            <div class="form-group m-3">
                <label for="keyWord">Buscar</label>
                <input type="text" wire:model.lazy="keyWord" class="form-control" placeholder="Busqueda">
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Roles</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->email}}</td>
                        <td>
                            @if ($item->roles->count() > 0)
                                <button wire:click="mdlVerRoles({{$item->id}})" class="btn btn-xs btn-primary"><i class="fa fa-user-shield"></i> {{$item->roles->count()}}</button>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <a href="/usuarios/{{$item->id}}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Editar</a>
                            <button onclick="destroy({{$item->id}},'Usuario: {{$item->name}}')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>
                    
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($this->selectedUser->id ?? false)
        @include('livewire.user.roles.modals.mdlVerRoles', ['model' => $this->selectedUser])
    @endif
</div>
