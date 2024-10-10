<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class Bonificacion extends BaseModel
{
    use HasFactory;

    protected $table = 'bonificaciones';

    protected $fillable = [
        'usuario_id',
        'cliente_id',
        'monto',
        'folio',
        'folio_de',
        'comentarios',
    ];
}
