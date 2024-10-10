<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class Familia extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'abreviacion'
    ];

    public function equipos(){
        return $this->hasMany(Equipo::class);
    }

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function setAbreviacionAttribute($value)
    {
        $this->attributes['abreviacion'] = strtoupper($value);
    }
}
