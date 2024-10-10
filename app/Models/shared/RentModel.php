<?php

namespace App\Models\shared;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class RentModel extends BaseModel
{
    use HasFactory;

    public function total(){
        if($this->registros){
            return $this->registros->reduce(function($carry, $item){
                return $carry + ($item->unidades * $item->cantidad * $item->precio);
            });
        }
        return 0;
    }

    public function totalProductos(){
        if($this->registros){
            return $this->registros->reduce(function($carry, $item){
                return $carry + $item->cantidad;
            });
        }
        return 0;
    }

    public function pagoMinimo($creditoDisponible){
        $montoRenta = $this->total();
        $pagoMinimo = $creditoDisponible <= 0 ? $montoRenta : ($montoRenta - $creditoDisponible);
        $pagoMinimo = $pagoMinimo <= 0 ? 0 : $pagoMinimo;
        return $pagoMinimo;
    }
}
