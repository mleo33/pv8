<?php

namespace App\Http\Livewire\Recargas;

use App\Http\Controllers\RecargasController;
use App\Http\Traits\PagarTrait;
use Livewire\Component;
use stdClass;

class RealizarRecarga extends Component
{
    use PagarTrait;

    public $providers;
    public $products;
    
    public $idSelectedProvider;
    public $selectedProvider;

    public $selectedProduct;

    public $numeroCelular;
    public $numeroCelular_confirmation;

    protected $rules = [
        'numeroCelular' => 'numeric|required|digits:10|confirmed',
    ];

    protected $listeners = [
        'recargaSuccess' => 'recargaSuccess',
    ];

    public function mount(){
        $this->initPagarTrait();
    }

    public function render()
    {
        if($this->idSelectedProvider){
            $this->products = RecargasController::GetProducts($this->idSelectedProvider);
            return view('livewire.recargas.realizar_recarga.products');
        }
        else{
            $this->providers = RecargasController::GetCarriers();
            return view('livewire.recargas.realizar_recarga.providers');
        }
    }

    public function getProducts($idProvider){
        $this->idSelectedProvider = $idProvider;

        $this->selectedProvider = collect($this->providers)->sole(function($value){
            return $value['ID'] == $this->idSelectedProvider;
        });
    }

    public function mdlRecarga($codigo){
        $this->numeroCelular = "";
        $this->numeroCelular_confirmation = "";
        
        $this->selectedProduct = collect($this->products)->sole(function($value) use ($codigo){
            return $value['Codigo'] == $codigo;
        });

        $this->pagoRequerido = $this->selectedProduct['Monto'];
        $this->emit('showModal', '#mdlPago');
    }

    public function realizarRecarga(){

        $this->validate();

        $data = new stdClass();
        $data->title = "{$this->selectedProduct['Carrier']} {$this->selectedProduct['Categoria']} \${$this->selectedProduct['Monto']}: {$this->numeroCelular}";
        $data->categoria = $this->selectedProduct['Categoria'];
        $data->compania = $this->selectedProduct['Carrier'];
        $data->codigo_producto = $this->selectedProduct['Codigo'];
        $data->referencia = $this->numeroCelular;
        $data->monto = $this->selectedProduct['Monto'];
        $data->pago = $this->montoTotal;
        

        $this->emit('post-recarga', $data, csrf_token(), 'recargaSuccess');
    }

    public function recargaSuccess(){
        $this->emit('ok', "Regarga");
    }

    public function mdlNoCelular(){
        $this->emit('closeModal', '#mdlPago');
        $this->emit('showModal', '#mdlNoCelular');
    }

    public function pagar(){
        // $this->realizarRecarga();
        $this->mdlNoCelular();
    }
} 
