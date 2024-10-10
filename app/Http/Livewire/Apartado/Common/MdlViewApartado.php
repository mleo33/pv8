<?php

namespace App\Http\Livewire\Apartado\Common;

use App\Models\Apartado;
use App\Models\Ingreso;
use App\Models\MovimientoInventario;
use App\Models\Venta;
use App\Models\VentaRegistro;
use Livewire\Component;

class MdlViewApartado extends Component
{
    public $apartado;
    public $mdlName = 'mdlViewApartado';
    public $montoAbono;

    protected $listeners = [
        'initMdlViewApartado' => 'initMdlViewApartado',
        'mdlCashPayment' => 'mdlCashPayment',
        'abonarApartado' => 'abonarApartado',
        'retirarApartado' => 'retirarApartado',
    ];
    
    public function initMdlViewApartado(Apartado $apartado){
        $this->apartado = $apartado;
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function render()
    {
        return view('livewire.apartado.common.mdl-view-apartado');
    }

    public function mdlCashPayment($amount){
        $this->montoAbono = $amount;
        $this->emit('initMdlCashPayment', $this->montoAbono, 'abonarApartado');
    }

    public function mdlPagoRetiro(){
        $this->montoAbono = $this->apartado->saldo;
        $this->emit('initMdlCashPayment', $this->montoAbono, 'retirarApartado');
    }

    public function abonarApartado($pagos){
        $this->registrarAbonos($pagos, Apartado::class, $this->apartado->id, 'ABONO');
        $this->apartado->refresh();
        $this->emit('ok', 'Se ha registrado abono');
    }

    public function retirarApartado($pagos){

        $venta = Venta::create([
            'cliente_id' => $this->apartado->cliente_id,
        ]);

        foreach ($this->apartado->conceptos as $item) {
            $vr = VentaRegistro::create([
                'venta_id' => $venta->id,
                'producto_id' => $item->producto_id,
                'codigo' => $item->codigo,
                'descripcion' => $item->descripcion,
                'cantidad' => $item->cantidad,
                'precio' => $item->precio,
            ]);

            if($vr->save()){
                $inventario = $vr->producto->inventario_actual();
                $inventario->existencia -= $vr->cantidad;
                if($inventario->save())
                {
                    MovimientoInventario::create([
                        'usuario_id' => $venta->usuario_id,
                        'tipo' => 'VENTA',
                        'producto_id' => $vr->producto_id,
                        'emisor_id' => $venta->sucursal_id,
                        'cantidad' => $vr->cantidad,
                        'comentarios' => 'Venta #' . str_pad($vr->venta_id, 4, '0', STR_PAD_LEFT),
                    ]);
                }
            }

        }

        $this->apartado->venta_id = $venta->id;
        $this->apartado->save();

        $this->registrarAbonos($pagos, Venta::class, $venta->id, 'PAGO');
        $this->emit('closeModal', "#{$this->mdlName}");
        $this->emit('ok', 'Puede entregar productos del apartado', 'Se ha registrado venta');
        $this->emitUp('updateCatalogoApartados');
        $this->emit('print', 'ticket_venta#'. $venta->id);

    }

    public function registrarAbonos($pagos, $model_type, $model_id, $tipo){
        $pagosCount = collect($pagos)->count();
        foreach($pagos as $ing)
        {
            $monto = $pagosCount == 1 ? $this->montoAbono : $ing['monto'];
            $pago = $ing['monto'];
            $cambio = floatval($pago) - floatval($monto);

            if($monto > 0){
                $ingreso = Ingreso::create([
                    'tipo' => $tipo,
                    'forma_pago' => $ing['forma'],
                    'monto' => $monto,
                    'referencia' => '',
                    'model_type' => $model_type,
                    'model_id' => $model_id,
                    'pago' => $pago,
                    'cambio' => $cambio,
                ]);
            }

        }
    }

    
}
