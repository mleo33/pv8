<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class Compra extends BaseModel
{
    use HasFactory;

    protected $table = 'compras';

    protected $fillable = [
        'usuario_id',
        'proveedor_id',
        'comentarios',
    ];
}
