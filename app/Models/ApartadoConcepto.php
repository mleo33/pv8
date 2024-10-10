<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartadoConcepto extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartado_id',
        'producto_id',
        'codigo',
        'descripcion',
        'cantidad',
        'precio',
    ];

    public function getImporteAttribute(){
        return $this->cantidad * $this->precio;
    }
}
