<?php

namespace App\Http\Livewire\Recargas;

use App\Models\Recarga;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Historial extends Component
{
    public $startDate;
    public $endDate;
    public $selectedRecarga;

    public function mount(){
        $this->startDate = date('Y-m-d');
        $this->endDate = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.recargas.historial.view', [
            'recargas' => Recarga::whereBetween('created_at', [$this->startDate, ($this->endDate . ' 23:59:59')])
            ->where('sucursal_id', Auth::user()->sucursal_default) ->get(),
        ]);
    }

    public function viewDetails($id_recarga){
        $this->selectedRecarga = Recarga::findOrFail($id_recarga);
        $this->emit('showModal', '#mdl');
    }
} 
