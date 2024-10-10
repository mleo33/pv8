<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class CompraRegistro extends BaseModel
{
    use HasFactory;
    
    protected $table = 'compra_registros';

    protected $fillable = [
        'compra_id',
        'producto_id',
        'codigo',
        'descripcion',
        'cantidad',
        'precio',
    ];
}
