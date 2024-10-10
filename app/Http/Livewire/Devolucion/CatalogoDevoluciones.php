<?php

namespace App\Http\Livewire\Devolucion;

use App\Http\Livewire\Classes\LivewireBaseCrudController;
use App\Models\Devolucion;
use Carbon\Carbon;

class CatalogoDevoluciones extends LivewireBaseCrudController
{
    protected $model_name = "Devolución";
    protected $model_name_plural = "Devoluciones";

    public $startDate;
    public $endDate;
    
    public function mount(){
        Parent::mount();
        $this->startDate = Carbon::today()->startOfMonth()->toDateString();
        $this->endDate = Carbon::today()->endOfMonth()->toDateString();
    }

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Devolucion();
    }

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('id', 'ASC')
        ->whereBetween('created_at', [$this->startDate, ($this->endDate . ' 23:59:59')])
        ->paginate(100);
        return view('livewire.devolucion.catalogo-devoluciones.view', compact('data'));
    }

}
