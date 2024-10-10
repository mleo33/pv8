<?php

namespace App\Http\Livewire;

use App\Models\Ingreso;
use App\Models\Venta;
use Livewire\Component;

class Ingresos extends Component
{
    public $ingreso;
    public Venta $venta;
    public $startDate;
    public $endDate;

    protected $rules = [
        'venta.comentarios' => 'string',
    ];

    public function mount(){
        $this->startDate = date('Y-m-d');
        $this->endDate = date('Y-m-d');
        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.ingresos.view',[
            'ingresos' => Ingreso::whereBetween('created_at', [$this->startDate, ($this->endDate . ' 23:59:59')])->get(),
        ]);
    }

    public function cancel(){
        $this->resetInput();
    }

    public function resetInput(){
        $this->ingreso = new Ingreso();
        $this->venta = new Venta();
    }

    public function viewVenta($id){
        $this->venta = Venta::findOrFail($id);
        $this->emit('showModal', '#mdlSaleDetails');
    }
}
