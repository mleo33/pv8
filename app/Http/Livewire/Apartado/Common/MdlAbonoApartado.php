<?php

namespace App\Http\Livewire\Apartado\Common;

use App\Models\Apartado;
use Livewire\Component;

class MdlAbonoApartado extends Component
{
    public $mdlName = 'mdlAbonoApartado';
    public $apartado;
    public $montoAPagar = 0;
    public $emitAction;

    protected $listeners = [
        'initMdlAbonoApartado' => 'initMdlAbonoApartado',
    ];

    public function rules(){
        return [
            'montoAPagar' => "required|numeric|lt:{$this->apartado->saldo}|min:1",
        ];
    }

    public function render()
    {
        return view('livewire.apartado.common.mdl-abono-apartado');
    }

    public function initMdlAbonoApartado(Apartado $apartado, $emitAction){
        $this->montoAPagar = 0;
        $this->resetValidation();
        $this->apartado = $apartado;
        $this->emitAction = $emitAction;
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function pay(){
        $this->validate();
        $this->emit('closeModal', "#{$this->mdlName}");
        $this->emit($this->emitAction, $this->montoAPagar);
    }

    public function saldoPendiente(){
        $saldo = 0;
        $montoAPagar = is_numeric($this->montoAPagar) ? $this->montoAPagar : 0;
        if($this->apartado){
            $saldo = $this->apartado->saldo - $montoAPagar;
            if($saldo < 0){
                return 0;
            }
        }
        return $saldo;
    }
}
