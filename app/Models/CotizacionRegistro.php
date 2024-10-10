<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class CotizacionRegistro extends BaseModel
{
    use HasFactory;

    protected $table = 'cotizacion_registros';

    protected $fillable = [
        'cotizacion_id',
        'model_id',
        'model_type',
        'codigo',
        'descripcion',
        'cantidad',
        'precio',
    ];

    public function getImporteAttribute(){
        return $this->cantidad * $this->precio;
    }

    public function model(){
        return $this->morphTo();
    }
}
