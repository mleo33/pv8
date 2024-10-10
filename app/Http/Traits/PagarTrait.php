<?php


namespace App\Http\Traits;

use Illuminate\Support\Collection;

trait PagarTrait {

    public $montoTotal;
    public $pagoRequerido;
    public Collection $formas_pago_venta;
    public Collection $formas_pago;
    public Collection $formas_pago_restantes;

    public function initPagarTrait(){
        $this->formas_pago_restantes = new Collection();
        $this->formas_pago_venta = new Collection([array('forma' => 'EFECTIVO', 'monto' => 0)]);
        $this->formas_pago = new Collection([
            'EFECTIVO',
            'TARJETA',
            'TRANSFERENCIA'
        ]);
        $this->changeFormaPago();
    }

    public function changeFormaPago()
    {
        $this->formas_pago_restantes = $this->formas_pago->diff($this->formas_pago_venta->pluck('forma'));
        $montoTotal = 0;
        foreach($this->formas_pago_venta as $elem) {
            $elem['monto'] = $elem['monto'] ? $elem['monto'] : 0; 
            $montoTotal += $elem['monto'];
        }
        $this->montoTotal = $montoTotal;
        $this->emit('$refresh');
    }

    
    public function addFormaPago()
    {
        if ($this->formas_pago_restantes->count() > 0) {
            $this->formas_pago_venta->push([
                'forma' => $this->formas_pago_restantes->first(),
                'monto' => 0,
            ]);
            $this->changeFormaPago();
        }
    }

    public function removeFormaPago($index)
    {
        $this->formas_pago_venta->splice($index, 1);
        $this->changeFormaPago();
    }
}