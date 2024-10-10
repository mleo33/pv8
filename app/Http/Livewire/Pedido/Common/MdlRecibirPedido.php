<?php

namespace App\Http\Livewire\Pedido\Common;

use App\Models\Pedido;
use App\Models\PedidoConcepto;
use Livewire\Component;

class MdlRecibirPedido extends Component
{
    public Pedido $pedido;
    public $mdlName = 'MdlRecibirPedido';
    public $productQty;

    protected $listeners = [
        'initMdlRecibirPedido',
        'recibir',
    ];

    protected $rules = [
        'productQty.*.recibir' => 'numeric',
    ];

    public function render()
    {
        return view('livewire.pedido.common.mdl-recibir-pedido');
    }

    public function initMdlRecibirPedido(Pedido $pedido){
        $this->pedido = $pedido;
        $this->productQty = $this->pedido->conceptos->mapWithKeys(function($item){
            return [
                $item->id => [
                    'recibir' => 0,
                    'cantidad' => $item->cantidad,
                    'pendiente_recibir' => $item->pendiente_recibir,
                ]
            ];
        });
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function errorMessage($id){
        $pendiente_recibir = $this->productQty[$id]['pendiente_recibir'];
        $recibir = $this->productQty[$id]['recibir'];

        if(!isset($recibir)){
            return "Campo requerido";
        }
        if($recibir > $pendiente_recibir){
            return "Max: {$pendiente_recibir}";
        }
        if($recibir < 0){
            return "Valor Inválido";
        }
    }

    public function isError(){
        return collect($this->productQty)->reduce(function($carry, $item){            
            $cant = $item['recibir'];
            $pend = $item['pendiente_recibir'];

            if(!isset($cant)){
                return $carry + 1;
            }
            if($cant > $pend){
                return $carry + 1;
            }
            if($cant < 0){
                return $carry + 1;
            }
            

            return $carry;
        });
    }

    public function recibir(){
        foreach ($this->productQty as $id => $item) {
            $recibir = $item['recibir'];
            if ($recibir > 0) {
                $concepto = PedidoConcepto::findOrFail($id);
                $concepto->recibirProducto($recibir);
            }
        }
        $this->emit('ok', 'Se ha recibido productos');
        $this->emit('closeModal', "#{$this->mdlName}");
        $this->emit('updateCatalogoPedidos');

    }
}
