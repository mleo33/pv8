<?php

namespace App\Http\Livewire\Classes;

use Livewire\Component;
use Livewire\WithPagination;

class LivewireBaseCrudController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $model;
    protected $model_name;
    protected $model_name_plural;
    public $keyWord;

    public $model_name_upper;
    public $model_name_lower;

    protected $listeners = [
        'destroy' => 'destroy'
    ];

    public function mount(){
        $this->model_name_upper = strtoupper($this->model_name);
        $this->model_name_lower = strtolower($this->model_name);
        $this->resetInput();
    }

    public function mdlCreate(){
        $this->resetInput();
        $this->emit('showModal', '#mdl');
    }

    public function mdlEdit($id)
    {
        $this->resetValidation();
        $this->model = $this->model::findOrFail($id);
        $this->emit('showModal', '#mdl');
    }

    public function mdlDelete($id)
    {
        $this->model = $this->model::findOrFail($id);
        $this->emit('confirm', "¿Desea eliminar {$this->model_name_lower}?", $this->model->descripcion, 'destroy', $this->model->id);
    }

    public function save()
    {
        $this->validate();
        $this->model->save();
        $this->emit('ok',"Se ha guardado {$this->model_name_lower}: {$this->model->descripcion}", $this->model->codigo);
        $this->emit('closeModal', '#mdl');
    }

    public function destroy($id){
        $this->model = $this->model::findOrFail($id);
        if($this->model->delete()){
            $this->emit('ok', "Se ha eliminado {$this->model_name_lower}: {$this->model->descripcion}");
        }
    }
}