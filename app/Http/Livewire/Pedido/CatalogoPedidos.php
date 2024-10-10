<?php

namespace App\Http\Livewire\Pedido;

use App\Http\Controllers\PedidoController;
use App\Http\Livewire\Classes\LivewireBaseCrudController;
use App\Models\Pedido;
use Carbon\Carbon;

class CatalogoPedidos extends LivewireBaseCrudController
{
    protected $model_name = "Pedido";
    protected $model_name_plural = "Pedidos";

    public $startDate;
    public $endDate;

    protected $listeners = [
        'updateCatalogoPedidos',
        'send' => 'sendMail',
    ];
    
    public function mount(){
        Parent::mount();
        $this->startDate = Carbon::today()->startOfMonth()->toDateString();
        $this->endDate = Carbon::today()->endOfMonth()->toDateString();
    }

    public function updateCatalogoPedidos(){
        $this->render();
    }

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Pedido();
    }

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('id', 'ASC')
        ->whereBetween('created_at', [$this->startDate, ($this->endDate . ' 23:59:59')])
        ->paginate(100);
        return view('livewire.pedido.catalogo-pedidos.view', compact('data'));
    }

    public function mdlEnviarCorreo($id){
        $this->model = $this->model::findOrFail($id);
        $mail = $this->model->proveedor->correo;
        $mailBody = "Se ha generado pedido para: {$this->model->proveedor->nombre}";
        $mailBody .= "\n\nMas información en el documento adjunto";
        $this->emit('initMdlEnviarPedidoCorreo', $this->model, $mail, $mailBody);
    }
}
