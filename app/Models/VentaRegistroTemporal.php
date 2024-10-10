<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class VentaRegistroTemporal extends BaseModel
{
    use HasFactory;

    protected $table = 'venta_registros_temporales';

    protected $fillable = [
        'venta_temporal_id',
        'producto_id',
        'codigo',
        'descripcion',
        'cantidad',
        'precio',
        'pagado',
        'descuento',
    ];

    public function importe(){
        return $this->cantidad * $this->precio_con_descuento;
    }

    public function getPrecioConDescuentoAttribute(){
        return $this->precio * (1 - ($this->descuento / 100));
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function addQty($qty){
        $this->cantidad + $qty;
        $this->save();
    }

    public function setPrecioAttribute($value){
        $this->attributes['precio'] = $value ? $value : 0;
    }
}
