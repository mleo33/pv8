<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Devolucion extends BaseModel
{
    use HasFactory;

    protected $table = 'devoluciones';

    protected $fillable = [
        'venta_id',
        'venta_registro_id',
        'codigo',
        'descripcion',
        'cantidad',
        'precio',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $user = Auth::user();

            $model->usuario_id = $user->id;
            $model->sucursal_id = $user->sucursal_default;
        });

    }
    
    public function user(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function cambios(){
        return $this->belongsToMany(VentaRegistro::class, 'devolucion_cambios');
    }

    public function getImporteAttribute(){
        return $this->cantidad * $this->precio;
    }

    
}
