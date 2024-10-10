<?php

namespace App\Http\Livewire;

use App\Models\Usd;
use Livewire\Component;

class Usdmxn extends Component
{
    public Usd $usd;

    protected $rules = [
        'usd.cotizacion' => 'numeric|min:1',
    ];

    public function mount(){
        $this->usd = Usd::find(1)->first();
    }

    public function render()
    {
        return view('livewire.usdmxn.view');
    }

    public function guardarUSD(){
        $this->validate();
        $this->usd->save();
        $this->emit('ok', 'Se han guardado cambios');
    }
}
