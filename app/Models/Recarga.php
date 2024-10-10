<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recarga extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'sucursal_id',
        'categoria',
        'compania',
        'producto',
        'referencia',
        'monto',
        'trans_id',
        'folio',
        'mensaje',
        'estatus',
        'response',
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function setEstatusAttribute($value){
        $this->attributes['estatus'] = strtoupper($value);
    }

    public function getColorAttribute(){
        switch (trim(strtoupper($this->estatus))) {
            case 'EXITOSA':
                return 'success';
                break;

            case 'FRACASADA':
                return 'danger';
                break;
            
            default:
                return 'secondary';
                break;
        }
    }
}
