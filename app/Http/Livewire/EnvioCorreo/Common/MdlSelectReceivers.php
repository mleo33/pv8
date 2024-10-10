<?php

namespace App\Http\Livewire\EnvioCorreo\Common;

use Livewire\Component;

class MdlSelectReceivers extends Component
{
    public $mdlName = "MdlSelectReceivers";

    protected $listeners = [
        'initMdlSelectReceivers'
    ];

    public function render()
    {
        return view('livewire.envio-correo.common.mdl-select-receivers');
    }

    public function initMdlSelectReceivers()
    {
        $this->emit('showModal', "#{$this->mdlName}");
    }
}
