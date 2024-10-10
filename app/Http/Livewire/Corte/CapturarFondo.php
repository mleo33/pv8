<?php

namespace App\Http\Livewire\Corte;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CapturarFondo extends Component
{
    public $user;

    public function mount()
    {
        $this->user = User::findOrFail(Auth::user()->id);
    }

    public function render()
    {
        return view('livewire.corte.capturar-fondo.view');
    }

}
