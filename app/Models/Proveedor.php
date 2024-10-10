<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class Proveedor extends BaseModel
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'calle',
        'numero',
        'numero_int',
        'colonia',
        'cp',
        'ciudad',
        'estado',
        'rfc',
        'telefono',
        'correo',
        'comentarios'
    ];

    public function getDireccionAttribute(){
        return $this->calle . ' ' . $this->numero . ', ' .$this->colonia;
    }
}
