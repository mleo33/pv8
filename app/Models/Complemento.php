<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complemento extends BaseModel
{
        use HasFactory;

    protected $table = 'complementos';

    protected $fillable = [
        'usuario_id',
        'sucursal_id',
        'emisor_id',
        'entidad_fiscal_id',
        'tipo',
        'forma_pago',
        'serie',
        'folio',
        'monto',
        'uuid',
        'xml',
        'estatus',
        'comentarios',
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
    
    public function emisor(){
        return $this->belongsTo(Emisor::class, 'emisor_id');
    }

    public function entidad_fiscal(){
        return $this->belongsTo(EntidadFiscal::class, 'entidad_fiscal_id');
    }

    public function facturas(){
        return $this->belongsToMany(Factura::class);
    }
}
