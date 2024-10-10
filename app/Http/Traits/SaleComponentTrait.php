<?php


namespace App\Http\Traits;

trait SaleComponentTrait {

    public function getFactorIvaAttribute(){
        return  $this->tasa_iva / 100;
    }

    public function getSubtotalAttribute(){
        if($this->conceptos){
            return $this->conceptos->reduce(function($carry, $item){
                return $carry + $item->importe;
            });
        }
        return 0;
    }

    public function getIvaAttribute(){
        return  $this->subtotal * $this->factor_iva;
    }

    public function getTotalAttribute(){
        return $this->subtotal + $this->iva;
    }

    public function getCantidadConceptosAttribute(){
        if($this->conceptos){
            return $this->conceptos->reduce(function($carry, $item){
                return $carry + $item->cantidad;
            });
        }
        return 0;
    }

}