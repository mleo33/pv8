<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class FacturaTemporalConcepto extends BaseModel
{
    use HasFactory;

    protected $table = 'factura_temporal_conceptos';

    protected $fillable = [
        'factura_temporal_id',
        'model_id',
        'model_type',
        'no_identificacion',
        'descripcion',
        'clave_prod_serv',
        'clave_unidad',
        'cantidad',
        'valor_unitario',
        'objeto_imp',
    ];

    public function factura_temporal(){
        return $this->belongsTo(FacturaTemporal::class);
    }

    public function model(){
        return $this->morphTo();
    }

    public function getValorUnitarioAttribute(){
        $tasa_iva = $this->factura_temporal->tasa_iva;
        $desglosar = $this->factura_temporal->desglosar_iva;

        if($desglosar){
            return round($this->attributes['valor_unitario'] / (1 + ($tasa_iva / 100)), 2);
        }

        return round($this->attributes['valor_unitario'], 2);
    }

    public function importe(){
        return round($this->cantidad * $this->valor_unitario, 2);
    }

    public function getImporteAttribute(){
        return $this->importe();
    }

    public function getIvaAttribute(){
        return $this->iva();
    }

    public function iva(){
        return round($this->importe() * ($this->factura_temporal->tasa_iva / 100), 2);
    }

    public function getImporteCIvaAttribute(){
        return round($this->importe() * (1 + ($this->factura_temporal->tasa_iva / 100)), 2);
    }

    public function getImporteSIvaAttribute(){
        return round($this->importe / (1 + $this->factor_iva), 2);
    }
}
