<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class MovimientoInventario extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'tipo',
        'producto_id',
        'emisor_id',
        'receptor_id',
        'cantidad',
        'comentarios'
    ];

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function emisor(){
        return $this->belongsTo(Sucursal::class, 'emisor_id');
    }

    public function receptor(){
        return $this->belongsTo(Sucursal::class, 'receptor_id');
    }
}
