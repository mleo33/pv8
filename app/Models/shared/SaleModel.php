<?php

namespace App\Models\shared;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class SaleModel extends BaseModel
{
    use HasFactory;

    public function getTotalAttribute(){
        return $this->total();
    }

    public function total(){
        if($this->registros){
            return $this->registros->reduce(function($carry, $item){
                return $carry + $item->importe();
            });
        }
        return 0;
    }

    public function getTotalProductosAttribute(){
        return $this->totalProductos();
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

    public function iva(){
        if($this->registros){
            return $this->registros->reduce(function($carry, $item){
                return $carry + $item->iva;
            });
        }
        return 0;
    }

    public function getIvaAttribute(){
        return $this->iva();
    }

    public function getSubtotalAttribute(){
        if($this->registros){
            return $this->registros->reduce(function($carry, $item){
                return $carry + $item->importe_s_iva;
            });
        }
        return 0;
    }

    public function total_c_iva(){
        if($this->registros){
            return $this->registros->reduce(function($carry, $item){
                return $carry + $item->importe_c_iva;
            });
        }
        return 0;
    }

    public function getTotalCIvaAttribute(){
        return $this->total_c_iva();
    }
}
