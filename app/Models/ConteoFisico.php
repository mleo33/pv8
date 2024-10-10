<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConteoFisico extends Model
{
    use HasFactory;

    protected $table = 'conteo_fisico';

    protected $fillable = [
        'sucursal_id',
        'user_id',
        'efectivo',
        'tarjeta',
        'transferencia',
        'cheque',
        'total',
    ];
}
