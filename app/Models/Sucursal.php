<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class Sucursal extends BaseModel
{
    use HasFactory;
    protected $table = 'sucursales';

    protected $fillable = [
        'nombre',
        'direccion',        
        'telefono',
        'emisor_id',
        'comentarios',
        'tasa_iva',
        'mensaje_ticket_venta',
        'mensaje_ticket_renta',
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function emisor(){
        return $this->belongsTo(Emisor::class);
    }
}
