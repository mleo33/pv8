<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\SaleModel;

class VentaTemporal extends SaleModel
{
    use HasFactory;

    protected $table = 'ventas_temporales';
    private $PagoRequerido = 0;

    protected $appends = ['PagoRequerido'];

    protected $fillable = [
        'usuario_id',
        'sucursal_id',
        'cliente_id',
        'comentarios',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function registros()
    {
        return $this->hasMany(VentaRegistroTemporal::class, 'venta_temporal_id');
    }

    public function getPagoRequeridoAttribute()
    {
        return $this->PagoRequerido;
    }

    public function setPagoRequeridoAttribute($value)
    {
        if(!is_numeric($value)){
            $this->PagoRequerido = 0;
            return;
        }

        $total = $this->total();
        if($value < 0 || $value > $total){
            $value = $total;
        }

        $this->PagoRequerido = $value;
    }
}
