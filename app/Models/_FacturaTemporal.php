<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\SaleModel;

class FacturaTemporal extends SaleModel
{
    use HasFactory;

    protected $table = 'facturas_temporales';

    protected $attributes = [
        'tipo_comprobante' => 'I',
        // 'forma_pago' => '01',
        // 'metodo_pago' => 'PUE',
        'exportacion' => '01',
        // 'uso_cfdi' => 'G03',
        'desglosar_iva' => false,
    ];

    protected $fillable = [
        'usuario_id',
        'sucursal_id',
        'cliente_id',
        'entidad_fiscal_id',
        'model_id',
        'model_type',
        'tasa_iva',
        'desglosar_iva',
        'tipo_comprobante',
        'forma_pago',
        'metodo_pago',
        'exportacion',
        'uso_cfdi',
        'xml',
        'comentarios',
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function entidad_fiscal(){
        return $this->belongsTo(EntidadFiscal::class, 'entidad_fiscal_id');
    }

    public function conceptos(){
        return $this->hasMany(FacturaTemporalConcepto::class);
    }

    public function registros(){
        return $this->conceptos();
    }



    public function model(){
        return $this->morphTo();
    }
}
