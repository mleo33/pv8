<?php

namespace App\Http\Livewire\Corte;

use App\Models\ConteoFisico;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CapturarConteoFisico extends Component
{
    public $efectivo = 0;
    public $tarjeta = 0;
    public $transferencia = 0;
    public $cheque = 0;

    public $user;
    public $fecha;

    public function total(){
        $total = 0;
        $total += $this->efectivo ? $this->efectivo : 0;
        $total += $this->tarjeta ? $this->tarjeta : 0;
        $total += $this->transferencia ? $this->transferencia : 0;
        $total += $this->cheque ? $this->cheque : 0;
        return $total;
    }

    public function getConteoRegistradoProperty(){
        return ConteoFisico::whereDate('created_at', $this->fecha)
        ->where('user_id', $this->user->id)->sum('total');
    }

    public function mount()
    {
        $this->fecha = date('Y-m-d');
        $this->user = User::findOrFail(Auth::user()->id);
    }

    public function render()
    {
        $total = $this->total();
        return view('livewire.corte.capturar-conteo-fisico.view', compact('total'));
    }

    public function capturarConteo(){

        if($this->total() <= 0){
            $this->emit('info', 'Sumatoria de conteo debe ser mayor a 0');
            return;
        }

        $this->validate([
            'efectivo' => 'required|numeric|min:0',
            'tarjeta' => 'required|numeric|min:0',
            'transferencia' => 'required|numeric|min:0',
            'cheque' => 'required|numeric|min:0',
        ]);

        ConteoFisico::create([
            'efectivo' => $this->efectivo,
            'tarjeta' => $this->tarjeta,
            'transferencia' => $this->transferencia,
            'cheque' => $this->cheque,
            'total' => $this->total(),
            'user_id' => $this->user->id,
            'sucursal_id' => $this->user->sucursal_default,
        ]);

        $this->efectivo = 0;
        $this->tarjeta = 0;
        $this->transferencia = 0;
        $this->cheque = 0;


        $this->emit('ok', 'Conteo registrado correctamente');
    }
}
