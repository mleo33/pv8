<?php

namespace App\Http\Livewire\User\Roles;

use App\Models\Permission;
use Livewire\Component;

class AdminPermissions extends Component
{
    public Permission $selectedPermission;
    public $permission_details = Permission::PERMISSION_DETAIL;

    public function mount(){
        $this->selectedPermission = new Permission();
    }

    public function render()
    {
        return view('livewire.user.roles.admin-permissions',[
            'permissions' => Permission::all(),
        ]);
    }

    public function mdlVerRoles($id){
        $this->selectedPermission = Permission::findById($id);
        $this->emit('showModal', '#mdlVerRoles');
    }

    // public function mdlVerUsers($id){
    //     $this->selectedPermission = Permission::findById($id);
    //     $this->emit('showModal', '#mdlVerUsers');
    // }
}
