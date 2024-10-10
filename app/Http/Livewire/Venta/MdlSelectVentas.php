<?php

namespace App\Http\Livewire\Venta;

use App\Models\Venta;
use Livewire\Component;
use Livewire\WithPagination;

class MdlSelectVentas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $mdlName = 'mdlSelectVentas';
    public $pageName = 'selectVentasPage';
    public $successAction = 'setVentas';
    public $keyWord;
    public $selectedIds;

    public $rules = [
        'selectedIds.*' => 'integer',
    ];

    protected $listeners = [
      'initMdlSelectVentas',
    ];

    public function initMdlSelectVentas(){
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function updatedKeyWord(){
        $this->resetPage($this->pageName);
    }

    public function render()
    {
        return view('livewire.venta.mdl-select-ventas', $this->getRenderData());
    }

    public function getRenderData(){

        return [
            'ventas' => Venta::orderBy('id', 'desc')
                ->orWhere('id', 'like', $this->keyWord.'%')
                ->orWhereHas('cliente', function($q){
                    $q->where('nombre', 'like', '%'.$this->keyWord.'%');
                })->paginate(50),
        ];
    }

    public function select(){
        $ids = [];
        foreach ($this->selectedIds as $key => $value) {
            if ($value === true) {
                $ids[$key] = $value;
            }
        }
        $this->selectedIds = [];
        $this->emit($this->successAction, $ids);
        $this->emit('closeModal', "#{$this->mdlName}");
    }
}
