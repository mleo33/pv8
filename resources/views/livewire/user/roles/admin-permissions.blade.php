<div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Roles</th>
                {{-- <th>Usuarios</th> --}}
            </tr>
        </thead>
        <tbody>
        @foreach ($permissions as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->name_format}}</td>
                <td>{{$permission_details[$item->name]}}</td>
                <td>
                    @if ($item->roles->count() > 0)                        
                        <button wire:click="mdlVerRoles({{$item->id}})" class="btn btn-xs btn-primary"><i class="fa fa-user-shield"></i> {{$item->roles->count()}}
                    @else
                        N/A
                    @endif
                </td>
                {{-- <td>
                    @if ($item->users->count() > 0)                        
                        <button wire:click="mdlVerUsers({{$item->id}})" class="btn btn-xs btn-primary"><i class="fa fa-user"></i> {{$item->users->count()}}
                    @else
                        N/A
                    @endif
                </td> --}}
            </tr>
        @endforeach
        </tbody>
    </table>

    @if ($this->selectedPermission->id)
        @include('livewire.user.roles.modals.mdlVerUsers', ['model' => $this->selectedPermission])
        @include('livewire.user.roles.modals.mdlVerRoles', ['model' => $this->selectedPermission])
    @endif
</div>