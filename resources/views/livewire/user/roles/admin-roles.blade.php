<div>
    <button wire:click="mdlCreateRole" class="m-3 btn btn-xs btn-success"><i class="fa fa-user-shield"></i> Agregar Rol</button>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Usuarios</th>
                <th>Permisos</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($roles as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->name_format}}</td>
                <td>
                    @if ($item->users->count() > 0)                        
                        <button wire:click="mdlVerUsers({{$item->id}})" class="btn btn-xs btn-primary"><i class="fa fa-user"></i> {{$item->users->count()}}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if ($item->permissions->count() > 0)                        
                        <button wire:click="mdlVerPermisos({{$item->id}})" class="btn btn-xs btn-primary"><i class="fa fa-key"></i> {{$item->permissions->count()}}
                    @else
                        N/A
                    @endif
                </td>
                <td><button wire:click="mdlEditPermissions({{$item->id}})" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Editar Permisos</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('livewire.user.roles.modals.mdlCreateRole')

    @if ($this->selectedRole->id)
        @include('livewire.user.roles.modals.mdlVerUsers', ['model' => $this->selectedRole])
        @include('livewire.user.roles.modals.mdlVerPermisos', ['model' => $this->selectedRole])
        @include('livewire.user.roles.modals.mdlEditPermissions', ['model' => $this->selectedRole])
    @endif
</div>