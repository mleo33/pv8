<?php

namespace App\Http\Livewire;

use App\Http\Controllers\PdfController;
use App\Models\Egreso;
use App\Models\Ingreso;
use App\Models\Sucursal;
use App\Models\Venta;
use App\Models\Renta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class Corte extends Component
{
    public $startDate;
    public $endDate;
    public $sucursal_id;
    public $user_id;
    public $corte = false;

    public $ingresos;
    public $egresos;
    public $i_ventas;
    public $i_rentas;

    protected $rules = [
        'sucursal_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function mount(){
        $this->startDate = date('Y-m-d');
        $this->endDate = date('Y-m-d');
        $this->user_id = 0;
        $this->sucursal_id = Auth::user()->sucursal->id;
    }

    public function render(){

        if($this->corte){
            return view('pdf.corte.corte_normal');
        } else {
            return view('livewire.corte.control_card',[
                'sucursales' => Auth::user()->sucursales,
                'usuarios_sucursal' => Sucursal::find($this->sucursal_id)->users,
            ]);
        }
        
    }

    public function generarCorte(){
        $url = "pdf/corte/{$this->sucursal_id}/{$this->user_id}/{$this->startDate}/{$this->endDate}";
        $this->emit('console', $this->startDate);
        $this->emit('console', $this->endDate);
        $this->emit('redirect', $url);
    }
}
