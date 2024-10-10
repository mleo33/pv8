<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Sucursal;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReporteVentas extends Component
{
    public Venta $venta;
    public $startDate;
    public $endDate;
    public $user_id;
    public $sucursal_id;

    public function mount(){
        $this->startDate = date('Y-m-d');
        $this->endDate = date('Y-m-d');
        $this->user_id = 0;
        $this->sucursal_id = Auth::user()->sucursal->id;
    }

    public function render()
    {
        return view('livewire.reportes.partials.control_card', [
            'title' => 'Reporte de Ventas',
            'sucursales' => Auth::user()->sucursales,
            'usuarios_sucursal' => Sucursal::find($this->sucursal_id)->users,
        ]);
    }

    public function generarReporte(){
        $this->emit('redirect_post', '/reporte_ventas', [
            '_token' => csrf_token(),
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'user_id' => $this->user_id,
            'sucursal_id' => $this->sucursal_id,
        ]);
    }
}
