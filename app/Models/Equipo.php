<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Illuminate\Support\Facades\DB;

class Equipo extends BaseModel
{
    use HasFactory;

    protected $attributes = [
        'activo' => true,
     ];

    protected $fillable = [
        'fua',
        'familia',
        'serie',
        'modelo',
        'year',
        'descripcion',
        'cantidad',
        'origen',
        'factura',
        'pedimento',
        'fecha_adquisicion',
        'horometro',
        'placas',
        'moneda',
        'cotizacion_usd',
        'valor_compra',
        'valor_traslado',
        'valor_importacion',
        'renta_hora',
        'renta_dia',
        'renta_semana',
        'renta_mes',
        'comentarios',
        'propietario',
        'activo',
    ];

    public function setDescripcionAttribute($value){
        $this->attributes['descripcion'] = strtoupper($value);
    }

    public function setSerieAttribute($value){
        $this->attributes['serie'] = strtoupper($value);
    }

    public function setModeloAttribute($value){
        $this->attributes['modelo'] = strtoupper($value);
    }

    public function setFacturaAttribute($value){
        $this->attributes['factura'] = strtoupper($value);
    }

    public function setPedimentoAttribute($value){
        $this->attributes['pedimento'] = strtoupper($value);
    }

    public function setPlacasAttribute($value){
        $this->attributes['placas'] = strtoupper($value);
    }

    public function familia(){
        return $this->belongsTo(Familia::class);
    }

    public function valor_total(){
        $total = $this->valor_compra;
        $total += $this->valor_traslado;
        $total += $this->valor_importacion;
        return $total;
    }

    public function disponible(){
        $disp = $this->cantidad - DB::table('renta_registros')
        ->join('rentas', 'rentas.id', '=', 'renta_registros.renta_id')
        ->where(['renta_registros.model_type' => Equipo::class, 'renta_registros.model_id' => $this->id, 'renta_registros.recibido' => false])
        ->get()->sum('unidades');

        $disp = $disp - DB::table('renta_registros_temporales')
        ->join('rentas_temporales', 'rentas_temporales.id', '=', 'renta_registros_temporales.renta_temporal_id')
        ->where(['renta_registros_temporales.model_type' => Equipo::class, 'renta_registros_temporales.model_id' => $this->id])
        ->get()->sum('unidades');

        return $disp;
    }

    public function clave_producto()
    {
        return $this->belongsTo(ClaveProducto::class);
    }

    public function clave_unidad()
    {
        return $this->belongsTo(ClaveUnidad::class);
    }
}
