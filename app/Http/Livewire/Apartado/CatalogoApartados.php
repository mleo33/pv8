<?php

namespace App\Http\Livewire\Apartado;

use App\Http\Livewire\Classes\LivewireBaseCrudController;
use App\Models\Apartado;
use Carbon\Carbon;

class CatalogoApartados extends LivewireBaseCrudController
{
    protected $model_name = "Apartado";
    protected $model_name_plural = "Apartados";

    protected $listeners = [
        'updateCatalogoApartados' => 'updateCatalogoApartados'
    ];

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Apartado();
    }

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('id', 'ASC')
        ->where('venta_id', null)
        ->where('vence', '>=', Carbon::today())
        ->paginate(50);
        return view('livewire.apartado.catalogo-apartados.view', compact('data'));
    }

    public function updateCatalogoApartados(){
        $this->render();
    }
}
