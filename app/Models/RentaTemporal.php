<?php

namespace App\Models;

use App\Models\shared\RentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentaTemporal extends RentModel
{
    use HasFactory;

    protected $table = 'rentas_temporales';

    protected $fillable = [
        'usuario_id',
        'sucursal_id',
        'cliente_id',
        'entidad_fiscal_id',
        'comentarios',
        'fecha_renta',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function entidad_fiscal(){
        return $this->belongsTo(EntidadFiscal::class);
    }

    public function registros(){
        return $this->hasMany(RentaRegistroTemporal::class, 'renta_temporal_id');
    }

    public function equipos(){
        return $this->hasMany(RentaRegistroTemporal::class, 'renta_temporal_id')->where(['model_type' => Equipo::class]);
    }

    public function traslados(){
        return RentaRegistroTemporal::Where(['renta_temporal_id' => $this->id, 'model_type' => Traslado::class])->get();
    }
}
