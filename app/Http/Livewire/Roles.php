<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

class Roles extends Component
{
    public function test(){
        $this->role = Role::findById(1);
        $this->role->syncPermissions([1, 2, 4, 3, "6", false]);
    }

    public $searchValue;
    public $editMode = false;
    public Role $role;
    public Collection $permisos;

    public function mount(){
        $this->role = new Role();
        $this->permisos = new Collection();
    }

    protected $listeners = [
        'destroy' => 'destroy'
    ];

    protected $rules = [
        'role.name' => 'string',
    ];

    public function render()
    {
        if($this->editMode)
        {
            return view('livewire.roles.edit',[
                'permissions' => Permission::all(),
            ]);
        }
        else
        {
            return view('livewire.roles.view', [
                'roles' => Role::orderBy('name', 'asc')
                        ->orWhere('name', 'LIKE', '%'. Str::slug($this->searchValue) .'%')->get(),
            ]);
        }
    }

    //               \|||/
    //               (o o)
    //      ------ooO-(_)-Ooo------
    //      Livewire custom methods

    public function edit($id)
    {
        $this->role = Role::findOrFail($id);
        $this->editMode = true;
        $this->permisos = Permission::all()->map(function ($item, $key) {
            return $this->role->permissions->contains($item->id) ? $item->id : false;
        });
        $this->role->name = Str::upper(str_replace('-', ' ', $this->role->name));
        $this->emit('showModal', '#mdl');
    }

    public function viewUsers($id)
    {
        $this->role = Role::findOrFail($id);
        $this->role->name = Str::upper(str_replace('-', ' ', $this->role->name));
        if($this->role->users->count() > 0)
        {
            $this->emit('showModal', '#mdlUsers');
        }
        else{
             $this->emit('info', 'No existen usuarios asignados a este rol', strtoupper($this->role->name));
        }
    }

    public function viewPermissions($id)
    {
        $this->role = Role::findOrFail($id);
        // $this->permisos = ["1"];
        $this->role->name = Str::upper(str_replace('-', ' ', $this->role->name));
        if($this->role->permissions->count())
        {
            $this->emit('showModal', '#mdlPermissions');
        }
        else{
             $this->emit('info', 'No existen permisos asignados a este rol', strtoupper($this->role->name));
        }
    }

    public function update()
    {
        $this->role->name = Str::slug($this->role->name);
        
        $this->validate([
            'role.name' => 'required|unique:roles,name,' . $this->role->id . '|string|min:4|max:30',
        ]);

        if($this->role->save()){
            $this->role->syncPermissions($this->permisos);
            $this->emit('closeModal');
            $this->emit('ok', 'Se ha guardado Rol: ' . Str::upper(str_replace('-', ' ', $this->role->name)));
            $this->resetInput();
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $role = Role::where('id', $id)->first();
            if($role->delete()){
                $this->emit('ok', 'Se ha eliminado Rol: ' . Str::upper(str_replace('-', ' ', $role->name)));
            }
        }
    }

    public function cancel()
    {
        $this->resetInput();
    }
	
    private function resetInput()
    {
        $this->role = new Role();
        $this->permisos = new Collection();
        $this->editMode = false;
    }
}
