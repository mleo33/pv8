<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Sucursal;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;

class Usuarios extends Component
{
    /// TEST //
    public $test = true;
    public function test(){
        $this->test = !$this->test;
    }

    public $activeTab = 1;
    public $xxx = false;
    public $keyWord;
    public User $usuario;
    public Collection $roles;
    public Collection $sucursales;

    public function mount()
    {
        $this->resetInput();
    }

    protected $listeners = [
        'destroy' => 'destroy'
    ];

    protected $rules = [
        'usuario.name' =>'string',
        'usuario.email' =>'string',
    ];

    public function render()
    {
        if(isset($this->usuario->id)){
            return view('livewire.usuarios.edit', [
                'catalogo_sucursales' => Sucursal::all(),
                'catalogo_roles' => Role::all(),
            ]);
        }
        else
        {
            $keyWord = '%'.$this->keyWord .'%';
            return view('livewire.usuarios.view', [
                'usuarios' => User::orderBy('sucursal_default', 'asc')
                ->orWhere('name', 'LIKE', $keyWord)
                ->get(),
            ]);
        }
        
    }

    //               \|||/
    //               (o o)
    //      ------ooO-(_)-Ooo------
    //      Livewire custom methods

    public function resetInput(){
        $this->usuario = new User();
        $this->roles = new Collection();
        $this->sucursales = new Collection();
        $this->activeTab = 1;
    }
    
    public function edit($id)
    {
        if($id == 0)
        {
            $this->resetInput();
        }
        else{
            $this->usuario = User::findOrFail($id);
            $this->sucursales = Sucursal::all()->map(function ($item, $key) {
                return $this->usuario->sucursales->contains($item->id) ? $item->id : false;
            });
            $this->roles = Role::all()->map(function ($item, $key) {
                return $this->usuario->roles->contains($item->id) ? $item->id : false;
            });
        }
        //$this->emit('$refresh');
        
        // $this->emit('setMarca', $this->producto->marca);
        // $this->emit('setCategoria', json_decode($this->producto->categorias));
        //$this->emit('showModal', '#mdl');
    }

    public function saveUser(){
        $this->validate([
            'usuario.name' =>'required|string',
            'usuario.email' =>'required|unique:users,email,' . $this->usuario->id . '|email',
        ]);
        if($this->usuario->save()){
            $this->emit('ok', 'Se ha guardado usuario: ' . strtoupper($this->usuario->name));
        }
    }

    public function saveSucursales(){
        $this->usuario->sucursales()->sync($this->sucursales->filter(function($item){ return $item; }));
        $this->emit('ok', 'Se han guardado sucursales de: ' . strtoupper($this->usuario->name));
    }

    public function saveRoles(){
        $this->usuario->syncRoles($this->roles);
        $this->emit('ok', 'Se han guardado roles de: ' . strtoupper($this->usuario->name));
    }

    public function destroy($id)
    {
        if ($id) {
            $prod = User::where('id', $id)->first();
            if($prod->delete()){
                $this->emit('ok', 'Se ha eliminado Usuario: ' . strtoupper($prod->name));
            }
        }
    }
}
