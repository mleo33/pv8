<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class IngresoPropietario extends BaseModel
{
    use HasFactory;

    protected $table = 'ingresos_propietario';

    protected $fillable = [
        'usuario_id',
        'ingreso_id',
        'model_id',
        'model_type',
        'monto',
        'propietario',
    ];

    public function fecha_format(){
        return Carbon::parse($this->created_at)->format('M/d/Y h:i A');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function ingreso(){
        return $this->belongsTo(Ingreso::class, 'ingreso_id');
    }

    public function model(){
        return $this->morphTo();
    }
}
