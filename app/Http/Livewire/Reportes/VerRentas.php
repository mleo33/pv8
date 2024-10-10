<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Renta;
use Livewire\Component;
use Livewire\WithPagination;

class VerRentas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public Renta $renta;
    public $startDate;
    public $endDate;
    public $searchValue;

    public function mount(){
        $this->startDate = date('Y-m-d');
        $this->endDate = date('Y-m-d');
        $this->resetInput();
    }

    public function render()
    {
        if($this->searchValue)
        {
            $rentas = Renta::orderBy('id', 'desc')
            ->orWhere('id', '=', $this->searchValue)
            ->orWhereHas('cliente', function($q){
                $q->where('nombre', 'like', '%'.$this->searchValue.'%');
            })->paginate(50);
        }
        else{
            $rentas = Renta::whereBetween('created_at', [$this->startDate, ($this->endDate . ' 23:59:59')])->paginate(50);
        }

        return view('livewire.rentas.reportes.view',[
            'rentas' => $rentas,
        ]);
    }

    public function cancel(){
        $this->resetInput();
    }

    public function resetInput(){
        $this->renta = new Renta();
    }

    public function viewRegistros($id){
        $this->renta = Renta::findOrFail($id);
        $this->emit('showModal', '#mdlRentDetails');
    }
}
