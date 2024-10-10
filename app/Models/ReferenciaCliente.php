<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class ReferenciaCliente extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'nombre',
        'direccion',
        'telefono1',
        'telefono2',
        'notas',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->nombre = strtoupper($model->nombre);
        });

        self::updating(function($model){
            $model->nombre = strtoupper($model->nombre);
        });
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
