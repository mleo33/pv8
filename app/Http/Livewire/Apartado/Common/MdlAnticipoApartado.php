<?php

namespace App\Http\Livewire\Apartado\Common;

use App\Models\VentaTemporal;
use Livewire\Component;

class MdlAnticipoApartado extends Component
{
    public $mdlName;
    public $venta;
    public $montoAPagar = 0;
    public $emitAction;

    protected $listeners = [
        'initMdlAnticipoApartado' => 'initMdlAnticipoApartado',
    ];

    public function rules(){
        return [
            'montoAPagar' => "required|numeric|lt:{$this->venta->total}|min:1",
        ];
    }

    public function mount(){
        $this->mdlName = 'mdlAnticipoApartado';
    }

    public function render()
    {
        return view('livewire.apartado.common.mdl-anticipo-apartado');
    }

    public function initMdlAnticipoApartado(VentaTemporal $venta, $emitAction){
        $this->venta = $venta;
        $this->emitAction = $emitAction;
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function saldoPendiente(){
        $saldo = 0;
        $montoAPagar = $this->montoAPagar ? $this->montoAPagar : 0;
        if($this->venta){
            $saldo = $this->venta->total - $montoAPagar;
            if($saldo < 0){
                return 0;
            }
        }
        return $saldo;
    }

    public function pay(){
        $this->validate();
        $this->emit('closeModal', "#{$this->mdlName}");
        $this->emitUp($this->emitAction, $this->montoAPagar);
    }
}
