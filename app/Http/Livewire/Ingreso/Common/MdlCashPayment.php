<?php

namespace App\Http\Livewire\Ingreso\Common;

use App\Classes\Constants;
use Livewire\Component;

class MdlCashPayment extends Component
{
    public $formas_pago_venta = Constants::FORMAS_PAGO_VENTA;
    public $formas_pago;
    public $paymentAmount;
    public $modalCashPayment;
    public $emitAction;

    protected $listeners = [
        'initMdlCashPayment' => 'initMdlCashPayment',
    ];

    public function mount(){
        $this->modalCashPayment = 'mdlCashPayment';
        $this->formas_pago = Collect([array('forma' => 'EFECTIVO', 'monto' => 0)]);
    }

    public function initMdlCashPayment($paymentAmount, $emitAction){
        $this->emitAction = $emitAction;
        $this->paymentAmount = $paymentAmount;
        $this->formas_pago = Collect([array('forma' => 'EFECTIVO', 'monto' => 0)]);
        $this->emit('showModal', "#{$this->modalCashPayment}");
    }

    public function render()
    {
        return view('livewire.ingreso.common.mdl-cash-payment');
    }

    public function formasPagoRestantes(){
        return collect($this->formas_pago_venta)->diff($this->formas_pago->pluck('forma'))->all();
    }

    public function removeFormaPago($index)
    {
        $this->formas_pago->splice($index, 1);
    }

    public function addFormaPago()
    {
        if (count($this->formasPagoRestantes()) > 0) {
            $this->formas_pago->push([
                'forma' => collect($this->formasPagoRestantes())->first(),
                'monto' => 0,
            ]);
        }
    }

    public function pay(){
        $this->emit('closeModal', "#{$this->modalCashPayment}");
        $this->emit($this->emitAction, $this->formas_pago);
    }
}
