<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ClaveProducto extends BaseModel
{
    use HasFactory;

    protected $table = 'clave_productos';

    protected $fillable = [
        'clave',
        'nombre',
    ];
    
    public function productos(){
        return $this->hasMany(Producto::class);
    }

    public function setClaveAttribute($value){
        $this->attributes['clave'] = strtoupper($value);
    }

    public function getDescripcionAttribute(){
        return $this->nombre;
    }

    public function getCodigoAttribute(){
        return $this->clave;
    }
}
