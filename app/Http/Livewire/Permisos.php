<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class Permisos extends Component
{
    public $searchValue;
    public Permission $permission;
    public Role $role;

    public function mount(){
        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.permisos.view', [
            'permissions' => Permission::orderBy('name', 'asc')
                    ->orWhere('name', 'LIKE', '%'. Str::slug($this->searchValue) .'%')->get(),
        ]);
    }

    //               \|||/
    //               (o o)
    //      ------ooO-(_)-Ooo------
    //      Livewire custom methods

    public function edit($id)
    {
        $this->permission = Permission::findOrFail($id);
        $this->permission->name = Str::upper(str_replace('-', ' ', $this->permission->name));
        $this->emit('showModal', '#mdl');
    }

    public function viewUsers($id)
    {
        $this->role = Role::findOrFail($id);
        $this->role->name = Str::upper(str_replace('-', ' ', $this->role->name));
        if($this->role->users->count() > 0)
        {
            $this->emit('closeModal', '#mdlRoles');
            $this->emit('showModal', '#mdlUsers');
        }
        else{
             $this->emit('info', 'No existen usuarios asignados a este rol', strtoupper($this->role->name));
        }
    }

    public function viewRoles($id)
    {
        $this->permission = Permission::findOrFail($id);
        $this->permission->name = Str::upper(str_replace('-', ' ', $this->permission->name));
        if($this->permission->roles->count() > 0)
        {
            $this->emit('showModal', '#mdlRoles');
        }
        else{
            $this->emit('info', 'No existen roles asignados a este permiso', strtoupper($this->permission->name));
        }
        
    }

    public function update()
    {
        $this->validate([
            'permission.name' => 'required|string|min:4|max:30',
        ]);

        $this->permission->name = Str::slug($this->permission->name);

        if($this->permission->save()){
            $this->emit('closeModal');
            $this->emit('ok', 'Se ha guardado Rol: ' . Str::upper(str_replace('-', ' ', $this->permission->name)));
            $this->resetInput();
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $permission = Permission::where('id', $id)->first();
            if($permission->delete()){
                $this->emit('ok', 'Se ha eliminado Rol: ' . strtoupper($permission->name));
            }
        }
    }

    public function cancel()
    {
        $this->resetInput();
    }
	
    private function resetInput()
    {
        $this->permission = new Permission();
        $this->role = new Role();
    }
}
