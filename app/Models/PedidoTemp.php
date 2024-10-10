<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoTemp extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'sucursal_id',
    ];

    public function conceptos(){
        return $this->hasMany(PedidoConceptoTemp::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function getTotalAttribute(){
        if($this->conceptos){
            return $this->conceptos->reduce(function($carry, $item){
                return $carry + $item->importe;
            });
        }
        return 0;
    }

    public function getTotalProductosAttribute(){
        if($this->conceptos){
            return $this->conceptos->reduce(function($carry, $item){
                return $carry + $item->cantidad;
            });
        }
        return 0;
    }


}
