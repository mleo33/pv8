<?php

namespace App\Http\Livewire\Cotizacion\Common;

use App\Http\Controllers\PedidoController;
use App\Models\Pedido;
use Livewire\Component;

class MdlEnviarCotizacionCorreo extends Component
{
    public $mdlName = 'mdlEnviarPedidoCorreo';

    public $pedido;
    public $inputMails;
    public $inputMailBody;

    protected $listeners = [
        'initMdlEnviarPedidoCorreo',
    ];

    public function initMdlEnviarPedidoCorreo(Pedido $pedido, $mail, $body){
        $this->pedido = $pedido;
        $this->inputMails = $mail;
        $this->inputMailBody = $body;
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function render()
    {
        return view('livewire.pedido.common.mdl-enviar-pedido-correo');
    }

    public function send(){
        PedidoController::enviarCorreo($this->pedido, $this->inputMailBody, $this->inputMails);
        $this->emit('ok','Se ha enviado pedido');
        $this->emit('closeModal', "#{$this->mdlName}");

    }
}

