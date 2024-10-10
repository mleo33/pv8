<?php

namespace App\Http\Livewire\Admin;

use App\Models\Comentario;
use App\Models\Ingreso;
use App\Models\IngresoPropietario;
use App\Models\Renta;
use App\Models\RentaRegistro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use PDO;

class AdminRenta extends Component
{
    public Renta $renta;
    public $activeTab = 1;
    public $regIndex;
    public $cancelItem;

    public $mdlComentarioTitle;
    public $mdlComentarioText;

    public Comentario $comentario;
    // public Ingreso $pago;

    protected $rules = [
        'renta.registros.*.a_pagar' => 'numeric',
        'renta.equipos.*.recibido' => 'boolean',
        'renta.equipos.*.cantidad' => 'numeric',
        'renta.equipos.*.precio' => 'numeric',
        'renta.equipos.*.tipo_renta' => 'string',
        'renta.equipos.*.horometro_final' => 'numeric',
        'pago.monto' => 'numeric',
        'pago.forma_pago' => 'string',
        'pago.referencia' => 'string|max:255',
        'pago.tipo' => 'string',
        'pago.model_type' => 'string',
        'pago.model_id' => 'integer',
        'pago.usuario_id' => 'integer',
        'comentario.mensaje' => 'string|max:255',
        // 'registro.cantidad' => 'numeric',
        // 'registro.recibido' => 'boolean',
    ];

    protected $listeners = [
        'cancelarRenta' => 'cancelarRenta',
    ];

    public function mount(){
        $this->comentario = new Comentario();
        $this->initPago();

        foreach ($this->renta->equipos as $item) {
            $item->ajusteRetorno();
        }
        foreach ($this->renta->registros as $item) {
            $item->a_pagar = 0;
        }
    }

    public function render()
    {
        return view('livewire.rentas.admin.view');
    }

    //               \|||/
    //               (o o)
    //      ------ooO-(_)-Ooo------
    //      Livewire custom methods

    public function initPago(){
        $this->pago = new Ingreso();
        $this->pago->monto = 0;
        $this->pago->tipo = 'ABONO';
        $this->pago->forma_pago = 'EFECTIVO';
        $this->pago->referencia = '';
        $this->pago->model_type = Renta::class;
        $this->pago->model_id = $this->renta->id;
        $this->pago->usuario_id = Auth::user()->id;
    }

    public function initComentario(){
        $this->comentario = new Comentario();
    }

    public function mdlHorometro($regIndx){
        $this->regIndex = $regIndx;
        $equipo = $this->renta->equipos[$this->regIndex];

        if($equipo->recibido && $equipo->horometro_inicio > 0)
        {
            if($equipo->horometro_final == null)
            {
                $equipo->horometro_final = $equipo->horometro_inicio;
            }
            $this->emit('showModal', '#mdlHorometro');
        }
    }

    public function mdlPago(){
        $this->emit('showModal', '#mdlPago');
    }

    public function setHorometro(){
        $init = $this->renta->equipos[$this->regIndex]->horometro_inicio;
        if($this->renta->equipos[$this->regIndex]->horometro_final >= $init){
            $this->emit('closeModal', '#mdlHorometro');
        } else {
            $this->emit('info', "Horómetro inicial: $init", 'Horómetro Inválido');
        }
    }

    public function cancelHorometro(){
        $this->renta->equipos[$this->regIndex]->recibido = false;
        $this->renta->equipos[$this->regIndex]->horometro_final = null;
    }

    public function cancelMdlPrecios(){

    }

    public function mdlRecibido($regIndx){
        $this->regIndex = $regIndx;
        $this->emit('showModal', '#mdlRecibido');
    }

    public function saveRenta(){
        foreach ($this->renta->equipos as $equipo) {

            $equipo->fecha_retorno = $equipo->retorno();

            if($equipo->recibido && $equipo->fecha_recibido == null){
                $equipo->fecha_recibido = now();
                $equipo->user_recibido = Auth::user()->id;
            }
            else if(!$equipo->recibido){
                $equipo->horometro_final = null;
            }
            
            if($equipo->save() && $equipo->horometro_final != null)
            {
                $equipo->model->horometro = $equipo->horometro_final;
                $equipo->model->save();
            }
        }
        $this->renta->refresh();
        $this->emit('ok', 'Se ha guardado renta');

        foreach ($this->renta->registros as $item) {
            $item->a_pagar = $item->saldo_pendiente();
        }
        $this->mdlPago();
    }

    public function registrarPago(){
        $this->pago->monto = $this->renta->registros->sum('a_pagar');
        $this->pago->referencia = $this->pago->forma_pago != "EFECTIVO" ? $this->pago->referencia : '';
        if($this->pago->save()){
            $id = $this->pago->id;
            foreach ($this->renta->registros as $elem) {
                if($elem->a_pagar > 0){
                    $a_pagar = $elem->a_pagar;
                    unset($elem->a_pagar);

                    $elem->pagado += $a_pagar;
                    $elem->push(IngresoPropietario::create([
                        'usuario_id' => Auth::user()->id,
                        'ingreso_id' => $this->pago->id,
                        'model_id' => $elem->id,
                        'model_type' => get_class($elem),
                        'monto' => $a_pagar,
                        'propietario' => $elem->propietario,
                    ]));

                    $elem->a_pagar = 0;
                }
            }

            $this->emit('ok', 'Se ha registrado pago');
            $this->emit('closeModal', '#mdlPago');
            $this->initPago();
            $this->renta->load('ingresos');
            $this->emit('print', '/ticket_abono_renta/'. $id);
        }
    }
    
    public function imprimirTicketAbono($id){
        $this->emit('print', '/ticket_abono_renta/' . $id);
    }

    public function addQty($regIndx, $qty){
        $ob = $this->renta->equipos[$regIndx];
        if (($ob->cantidad + $qty) < 1) {
            return;
        }
        $ob->cantidad += $qty;
    }

    public function setTipoRenta($tipo){
        $reg = $this->renta->equipos[$this->regIndex];
        switch ($tipo) {
            case 'HORA':
                $reg->precio = $reg->model->renta_hora;
                break;

            case 'DIA':
                $reg->precio = $reg->model->renta_dia;
                break;
                    
            case 'SEMANA':
                $reg->precio = $reg->model->renta_semana;
                break;

            case 'MES':
                $reg->precio = $reg->model->renta_mes;
                break;
        }
        $reg->tipo_renta = $tipo;
        $this->emit('closeModal', '#mdlRentaPrecios');
    }

    public function mdlPrecioRentas($regIndx){
        //$ob = $this->renta->equipos[$regIndx];
        //$this->emit('closeModal', '#mdlSelectEquipment');
        $this->regIndex = $regIndx;
        $this->emit('showModal', '#mdlRentaPrecios');
    }

    public function confirmCancel(){
        $this->validate(['comentario.mensaje' => 'string|min:10|max:255']);
        $this->emit('warning-confirm', '¿Desea cancelar contrato?', 'Cancelar Renta', 'cancelarRenta');
    }

    public function cancelarRenta(){
        $this->comentario->tipo = 'CANCELACION';
        $this->comentario->model_id = $this->renta->id;
        $this->comentario->model_type = Renta::class;
        $this->comentario->usuario_id = Auth::user()->id;
        if($this->comentario->save()){
            $this->initComentario();
            $this->emit('closeModal');
        }

        foreach ($this->renta->equipos as $equipo) {
            $equipo->recibido = true;
            $equipo->fecha_recibido = now();
            $equipo->user_recibido = Auth::user()->id;
            $equipo->save();
        }

        foreach($this->renta->ingresos as $ingreso){
            $ingreso->canceled_at = now();
            $ingreso->canceled_by = Auth::user()->id;
            $ingreso->save();
        }

        $this->renta->canceled_at = now();
        $this->renta->canceled_by = Auth::user()->id;
        $this->renta->save();
        $this->renta->refresh();
        $this->emit('warning', 'Se ha cancelado renta');
    }

    public function mdlCancelBy($item){
        $this->emit('console', $item['cancelado_por']);
        return;
        //$this->cancelItem = $item;
        $this->emit('showModal', '#mdlCancelBy');
    }

    public function mdlComentario($id){
        $this->emit('showModal', '#mdlComentario');
    }

    public function mdlComentarioCancelacion(){
        $this->emit('showModal', '#mdlComentarioCancelacion');
    }

    public function agregarComentario(){
        $this->validate(['comentario.mensaje' => 'string|min:10|max:255']);

        $this->comentario->tipo = 'NORMAL';
        $this->comentario->model_id = $this->renta->id;
        $this->comentario->model_type = Renta::class;
        $this->comentario->usuario_id = Auth::user()->id;
        if($this->comentario->save()){
            $this->emit('ok', 'Se ha agregado comentario');
            $this->initComentario();
            $this->renta->load('comentarios');
            $this->emit('closeModal');
        }
    }
}
