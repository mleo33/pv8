<?php

namespace App\Models;

use App\Http\Traits\SaleComponentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\RentModel;

class CotizacionTemporal extends RentModel
{
    use HasFactory, SaleComponentTrait;

    protected $table = 'cotizaciones_temporales';

    protected $fillable = [
        'usuario_id',
        'sucursal_id',
        'cliente_id',
        'tasa_iva',
        'vigencia',
        'comentarios',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function conceptos(){
        return $this->hasMany(CotizacionRegistroTemporal::class, 'cotizacion_temporal_id');
    }
}
