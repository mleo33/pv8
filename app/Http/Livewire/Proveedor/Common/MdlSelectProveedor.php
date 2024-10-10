<?php

namespace App\Http\Livewire\Proveedor\Common;

use App\Models\Proveedor;
use Livewire\Component;
use Livewire\WithPagination;

class MdlSelectProveedor extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $mdlName = 'mdlSelectProveedor';
    public $emitAction;
    public $searchValue;
    
    public function updatedSearchValue(){
        $this->resetPage('selectProveedorPage');
    }

    public function mount($emitAction){
        $this->emitAction = $emitAction;
    }

    public function render()
    {
        return view('livewire.proveedor.common.mdl-select-proveedor',[
            'proveedores' => Proveedor::orderBy('nombre')
            ->orWhere('nombre', 'LIKE', "%{$this->searchValue}%")
            ->paginate(50, ['*'], 'selectProveedorPage'),
        ]);
    }

    public function select($id){
        // $this->validate();
        $this->emit('closeModal', "#{$this->mdlName}");
        $this->emitUp($this->emitAction, $id);
    }
}
