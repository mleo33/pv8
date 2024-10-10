<?php

namespace App\Http\Livewire\Devolucion\Common;

use Livewire\Component;

class BtnDevolucionDetalles extends Component
{
    public $devolucion;
    public $modalName;

    public function mount($devolucion){
        $this->devolucion = $devolucion;
        $this->modalName = 'mdlDevolucionDetalle' . uniqid();
    }

    public function render()
    {
        return view('livewire.devolucion.common.btn-devolucion-detalles');
    }
}
