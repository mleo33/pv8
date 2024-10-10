<?php


namespace App\Http\Traits;

use App\Models\Ingreso;
use Illuminate\Support\Facades\Auth;

trait PagosTrait {

    public Ingreso $pago;

    public function initPago(){
        $this->pago = new Ingreso();
        $this->pago->monto = 0;
        $this->pago->tipo = 'ABONO';
        $this->pago->forma_pago = 'EFECTIVO';
        $this->pago->referencia = '';
        $this->pago->usuario_id = Auth::user()->id;
    }

    public function registrarPago(){
        $this->validate([
            'pago.monto' => 'numeric|max:' . $this->venta->saldo,
        ]);

        $this->pago->model_type = $this->modelClass;
        $this->pago->model_id = $this->model->id;
        $this->pago->referencia = $this->pago->forma_pago != "EFECTIVO" ? $this->pago->referencia : '';

        if($this->pago->save()){
            $this->emit('ok', 'Se ha registrado pago');
            $this->emit('closeModal', '#mdlPago');
            $this->loadIngresos();
            $this->initPago();
            // $this->emit('print', '/ticket_abono_renta/'. $id);
        }
    }
}