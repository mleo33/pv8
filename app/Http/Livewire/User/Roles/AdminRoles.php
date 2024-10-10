<?php

namespace App\Http\Livewire\User\Roles;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class AdminRoles extends Component
{
    public Role $selectedRole;
    public $permission_details = Permission::PERMISSION_DETAIL;
    public $permisos;

    protected $rules = [
        'selectedRole.name' => 'string|required|min:5',
        'permisos.*' => 'boolean',
    ];

    public function mount(){
        $this->selectedRole = new Role();
    }

    public function render()
    {
        return view('livewire.user.roles.admin-roles',[
            'roles' => Role::orderBy('name')->where('name', '!=', 'superuser')
            ->get(),
            'permissions' => Permission::orderBy('name')->get(),
        ]);
    }

    public function mdlVerPermisos($id){
        $this->selectedRole = Role::findById($id);
        $this->emit('showModal', '#mdlVerPermisos');
    }

    public function mdlVerUsers($id){
        $this->selectedRole = Role::findById($id);
        $this->emit('showModal', '#mdlVerUsers');
    }

    public function mdlEditPermissions($id){
        $this->selectedRole = Role::findById($id);
        $this->permisos = Permission::all()->mapWithKeys(function ($item, $key) {
            return [$item['id'] => $this->selectedRole->permissions->contains($item->id)];
        });
        $this->emit('showModal', '#mdlEditPermissions');
    }

    public function mdlCreateRole(){
        $this->selectedRole = new Role();
        $this->emit('showModal', '#mdlCreateRole');
    }

    public function createRole(){
        $this->validate([
            'selectedRole.name' => 'string|required|min:5|unique:roles,name',
        ]);

        if($this->selectedRole->save()){
            $this->emit('ok', "Se ha creado Rol: " . $this->selectedRole->name_format);
            $this->emit('closeModal', '#mdlCreateRole');
        }
    }

    public function savePermissions(){
        $perms = array_filter($this->permisos->toArray(), function($item){
            return $item;
        });

        $this->selectedRole->syncPermissions(array_keys($perms));
        $this->emit('ok', 'Se han guardado permisos: ' . $this->selectedRole->name_format);
        $this->emit('closeModal', '#mdlEditPermissions');
    }
}
