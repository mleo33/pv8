<?php

namespace App\Http\Livewire\User;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class EditUser extends Component
{
    public User $user;
    public $userRoles;

    protected $rules = [
        'user.name' => 'string|required|min:5',
        'user.email' => 'email|required',
        'userRoles.*' => 'boolean',
    ];

    public function mount(User $user){
        $this->user = $user;
        $this->userRoles = Role::all()->mapWithKeys(function ($item, $key) {
            return [
                $item['id'] => $this->user->roles->contains($item->id)
            ];
        });
    }

    public function render()
    {
        return view('livewire.user.edit-user.view',[
            'roles' => Role::orderBy('name')
            ->where('name', '!=', 'superuser')
            ->get(),
        ]);
    }

    public function save(){
        $this->validate([
            'user.name' => 'string|required|min:5',
            'user.email' => "email|required|unique:users,email,{$this->user->id}",
        ]);

        $roles = array_filter($this->userRoles->toArray(), function($item){
            return $item;
        });

        $this->user->syncRoles(array_keys($roles));

        if($this->user->save()){
            $this->emit('ok', 'Se ha guardado usuario: ' . $this->user->name);
            return redirect()->to("/usuarios");

        }
    }
}
