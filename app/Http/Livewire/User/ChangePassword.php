<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    public $user;
    public $password_old;
    public $password;
    public $password_confirmation;


    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.user.change-password.view');
    }

    public function changePassword(){
        $this->validate([
            'password_old' => 'required',
            'password' => 'required|confirmed|min:3',
            'password_confirmation' => 'required|min:3',
        ]);

        if(!Hash::check($this->password_old, $this->user->password)){
            $this->emit('error', 'Contraseña actual incorrecta');
            return;
        }
        $this->user->password = Hash::make($this->password);
        $this->user->save();
        
        $this->emit('ok', 'Se ha cambiado contraseña');
        return redirect()->to('/');
    }
}
