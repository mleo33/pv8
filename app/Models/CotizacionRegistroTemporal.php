<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Carbon\Carbon;

class CotizacionRegistroTemporal extends BaseModel
{
    use HasFactory;

    protected $table = 'cotizacion_registros_temporales';

    protected $fillable = [
        'cotizacion_temporal_id',
        'model_type',
        'model_id',
        'codigo',
        'descripcion',
        'cantidad',
        'precio',
    ];

    public function getImporteAttribute(){
        return $this->cantidad * $this->precio;
    }

    public function model(){
        return $this->morphTo();
    }

    public function addQty($qty){
        $this->cantidad + $qty;
        $this->save();
    }
}
