<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;

class VerVentas extends Component
{
    public Venta $venta;
    public $startDate;
    public $endDate;

    protected $listeners = ['cancelarVenta'];

    public function mount(){
        $this->startDate = Carbon::today()->startOfMonth()->toDateString();
        $this->endDate = Carbon::today()->endOfMonth()->toDateString();
        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.ventas.reportes.view',[
            'ventas' => Venta::whereBetween('created_at', [$this->startDate, ($this->endDate . ' 23:59:59')])->get(),
        ]);
    }

    public function cancel(){
        $this->resetInput();
    }

    public function resetInput(){
        $this->venta = new Venta();
    }

    public function viewRegistros($id){
        $this->venta = Venta::findOrFail($id);
        $this->emit('showModal', '#mdlSaleDetails');
    }

    public function cancelarVenta($id){
        $venta = Venta::findOrFail($id);
        $venta->cancelar();
        $this->emit('ok', 'Venta cancelada');
    }
}
