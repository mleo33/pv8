<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class CatalogoUsers extends Component
{
    public $keyWord;
    public $selectedUser;
    
    protected $listeners = [
        'destroy'
    ];

    public function render()
    {
        return view('livewire.user.catalogo-users.view',[
            'users' => User::orderBy('name')
            ->where('id', '!=', 1)
            ->where('active', 1)
            ->where(function($q){
                $q->orWhere('name', 'LIKE', "%{$this->keyWord}%");
                $q->orWhere('email', 'LIKE', "%{$this->keyWord}%");
            })
            ->get(),
        ]);
    }

    public function mdlVerRoles($id){
        $this->selectedUser = User::findOrFail($id);
        $this->emit('showModal', '#mdlVerRoles');
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->syncRoles([]);
        $user->active = false;
        $user->save();

        $this->emit('ok','Se ha eliminado usuario');
    }
}
