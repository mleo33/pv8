<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class EntidadFiscal extends BaseModel
{
    use HasFactory;

    protected $table = 'entidades_fiscales';

    protected $fillable = [
        'model_id',
        'model_type',
        'razon_social',
        'regimen_fiscal',
        'calle',
        'numero',
        'numero_int',
        'colonia',
        'cp',
        'ciudad',
        'estado',
        'rfc',
        'correo',
        'comentarios',
    ];

    public function model(){
        return $this->morphTo();
    }

    public function setRazonSocialAttribute($value){
        $this->attributes['razon_social'] = trim($value);
    }
    

    public function getDireccionAttribute(){
        $dir = $this->calle;
        $dir .= ' ' . $this->numero;
        if($this->numero_int){
            $dir .= ' ' . $this->numero_int;
        }
        $dir .= ', ' . $this->colonia;

        return $dir;
    }
}
