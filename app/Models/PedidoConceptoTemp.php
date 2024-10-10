<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoConceptoTemp extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_temp_id',
        'producto_id',
        'codigo',
        'descripcion',
        'cantidad',
        'precio',
    ];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function getImporteAttribute(){
        if(is_numeric($this->cantidad) && is_numeric($this->precio)){
            return $this->cantidad * $this->precio;
        }
        return 0;
    }
}
