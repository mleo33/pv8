<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Illuminate\Support\Facades\Auth;

class Producto extends BaseModel
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'productos';

    protected $attributes = [
        'unidad' => 'PIEZA',
        'clave_producto_id' => 1,
        'clave_unidad_id' => 1,
    ];

    protected $fillable = [
        'codigo',
        'marca',
        'descripcion',
        'unidad',
        'clave_producto_id',
        'clave_unidad_id',
        'categorias',
    ];

    public function setDescripcionAttribute($value){
        $this->attributes['descripcion'] = trim(strtoupper($value));
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }

    public function movimientos_inventario()
    {
        return $this->hasMany(MovimientoInventario::class);
    }

    public function inventario_actual()
    {
        return Inventario::where(['producto_id' => $this->id, 'sucursal_id' => Auth::user()->sucursal_default])->first();
    }

    public function current_inventory()
    {
        return $this->hasOne(Inventario::class, 'producto_id')->where('sucursal_id', Auth::user()->sucursal_default);
    }

    public function clave_producto()
    {
        return $this->belongsTo(ClaveProducto::class,'clave_producto_id');
    }

    public function clave_unidad()
    {
        return $this->belongsTo(ClaveUnidad::class,'clave_unidad_id');
    }
	
}
