<?php

namespace App\Http\Livewire\Producto\Common;

use Livewire\Component;

class MdlSelectQty extends Component
{
    public $mdlName = 'mdlSelectQty';
    public $emitAction;

    public $qty;

    protected $listeners = [
        'initMdlSelectQty' => 'initMdlSelectQty',
    ];

    public function render()
    {
        return view('livewire.producto.common.mdl-select-qty');
    }

    public function mount($emitAction){
        $this->emitAction = $emitAction;
    }

    public function initMdlSelectQty($qty){
        $this->qty = $qty;
        $this->emit('focus', '#focusIpt');
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function select(){
        $this->emit($this->emitAction, $this->qty);
        $this->emit('closeModal', "#{$this->mdlName}");
    }
}
