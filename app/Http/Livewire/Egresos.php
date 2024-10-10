<?php

namespace App\Http\Livewire;

use App\Models\Egreso;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Egresos extends Component
{
    public Egreso $egreso;
    public $startDate;
    public $endDate;

    protected $rules = [
        'egreso.monto' => 'numeric|min:1',
        'egreso.forma_pago' => 'string',
        'egreso.concepto' => 'string|min:10|max:255',
    ];

    public function mount(){
        $this->startDate = date('Y-m-d');
        $this->endDate = date('Y-m-d');
        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.egresos.view',[
            'egresos' => Egreso::whereBetween('created_at', [$this->startDate, ($this->endDate . ' 23:59:59')])->get(),
        ]);
    }

    public function cancel(){
        $this->resetInput();
    }

    public function resetInput(){
        $this->egreso = new Egreso();
        $this->egreso->forma_pago = 'EFECTIVO';
    }

    public function mdlEgreso(){
        $this->emit('showModal', '#mdlEgreso');
    }

    public function registrarEgreso(){
        $this->validate();
        $user = Auth::user();
        $this->egreso->usuario_id = $user->id;
        $this->egreso->sucursal_id = $user->sucursal_default;
        $this->egreso->tipo = 'NORMAL';
        if($this->egreso->save()){
            $this->emit('ok', 'Se ha registrado Egreso');
            $this->emit('closeModal', '#mdlEgreso');
            $this->resetInput();
        }
    }
}
