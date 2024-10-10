<?php

namespace App\Http\Livewire\Reportes;

use App\Http\Controllers\FacturaController;
use App\Models\Factura;
use Carbon\Carbon;
use Livewire\Component;

class VerFacturas extends Component
{
    public Factura $factura;
    public $startDate;
    public $endDate;

    protected $rules = [
        'factura.entidad_fiscal.correo' => 'string',
    ];

    public function mount(){
        $this->startDate = Carbon::today()->startOfMonth()->toDateString();
        $this->endDate = Carbon::today()->endOfMonth()->toDateString();
        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.facturas.reportes.view',[
            'facturas' => Factura::whereBetween('created_at', [$this->startDate, ($this->endDate . ' 23:59:59')])->get(),
        ]);
    }

    public function cancel(){
        $this->resetInput();
    }

    public function resetInput(){
        $this->factura = new Factura();
    }

    public function viewRegistros($id){
        $this->renta = Factura::findOrFail($id);
        //$this->emit('showModal', '#mdlRentDetails');
    }

    public function mdlEnviarFactura(Factura $factura){
        $this->resetValidation();
        $this->factura = $factura;
        $this->factura->load('entidad_fiscal');
        $this->emit('showModal', '#mdlEnviarFactura');
    }

    public function enviarCorreo(){
        $this->validate([
            'factura.entidad_fiscal.correo' => 'email|required',
        ]);
        FacturaController::enviarCorreo($this->factura);
        $this->emit('ok', 'Se ha enviado factura a ' . $this->factura->entidad_fiscal->correo, 'Factura #' . $this->factura->id . ' Enviada');
    }
}
