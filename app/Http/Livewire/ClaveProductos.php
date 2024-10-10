<?php

namespace App\Http\Livewire;

use App\Models\ClaveProducto;
use App\Http\Livewire\Classes\LivewireBaseCrudController;

class ClaveProductos extends LivewireBaseCrudController
{
    protected $model_name = "Clave de Producto";
    protected $model_name_plural = "Claves de Producto";
    
    protected $rules = [
        'model.clave' => 'string|min:3|max:30',
        'model.nombre' => 'string|min:3|max:255',
    ];

    public function save(){
        $this->validate([
            'model.clave' => "unique:clave_productos,clave,{$this->model->id}",
        ]);
        Parent::save();
    }

    public function resetInput(){
        $this->resetValidation();
        $this->model = new ClaveProducto();
    }

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('id', 'ASC')->orWhere('nombre', 'LIKE', $keyWord)->paginate(100);
        return view('livewire.claves_productos.view', compact('data'));
    }

}
