<?php

namespace App\Http\Livewire\Ventas;

use App\Http\Traits\ComentariosTrait;
use App\Http\Traits\PagosTrait;
use App\Http\Traits\VentaTrait;
use App\Models\Comentario;
use App\Models\Ingreso;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerVenta extends Component
{
    use ComentariosTrait, VentaTrait, PagosTrait;

    public $model;
    public $modelClass;
    
    public $activeTab = 1;

    public Venta $venta;
    public Ingreso $pago;
    public Comentario $comentario;
    public Venta $focusElement;

    protected $rules = [
        'pago.monto' => 'numeric',
        'pago.forma_pago' => 'string',
        'pago.tipo' => 'string',
        'pago.model_type' => 'string',
        'pago.model_id' => 'integer',
        'pago.usuario_id' => 'integer',
        'comentario.mensaje' => 'string|max:255',
    ];

    public function mount(Venta $venta){
        $this->venta = $venta;
        $this->focusElement = new Venta();

        $this->initTraits();
    }

    public function initTraits(){
        $this->model =& $this->venta;
        $this->modelClass = Venta::class;

        $this->initComentario();
        $this->initPago();
    }

    public function loadComentarios(){
        $this->venta->load('comentarios');
    }

    public function loadIngresos(){
        $this->venta->refresh();
    }

    public function render()
    {
        return view('livewire.ventas.ver-venta.view');
    }

    public function cancel(){}
}
