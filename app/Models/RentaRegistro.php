<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class RentaRegistro extends BaseModel
{
    use HasFactory;

    protected $table = 'renta_registros';

    protected $fillable = [
        'renta_id',
        'model_type',
        'model_id',
        'fua',
        'descripcion',
        'unidades',
        'tipo_renta',
        'cantidad',
        'precio',
        'horometro_inicio',
        'horometro_final',
        'fecha_retorno',
        'recibido',
        'fecha_recibido',
        'user_recibido',
        'propietario',
    ];

    public function getCantidadAttribute($value)
    {
        return $value ? $value : 1;
    }

    public function renta(){
        return $this->belongsTo(Renta::class);
    }

    public function importe(){
        return $this->unidades * $this->cantidad * $this->precio;
    }

    public function retorno(){
        $fecha = Carbon::parse($this->renta->fecha);
        switch ($this->tipo_renta) {
            case 'HORA':
                $fecha->addMinutes($this->cantidad * 60);
                break;

            case 'DIA':
                $fecha->addHours($this->cantidad * 24);
                break;

            case 'SEMANA':
                $fecha->addHours($this->cantidad * 24 * 7);
                break;

            case 'MES':
                $fecha->addHours($this->cantidad * 24 * 30);
                break;
        }
        return $fecha;
    }

    public function ajusteRetorno(){
        if(!$this->fecha_recibido && $this->fecha_retorno < now()){
            $initDate = Carbon::parse($this->renta->fecha);
            $endDate = Carbon::parse(now());

            switch ($this->tipo_renta) {
                case 'HORA':
                    $this->cantidad = number_format($endDate->diffInMinutes($initDate) / 60, 2);
                    break;
    
                case 'DIA':
                    $this->cantidad = number_format($endDate->diffInHours($initDate) / 24, 2);
                    break;
    
                case 'SEMANA':
                    $this->cantidad = number_format($endDate->diffInHours($initDate) / 24 / 7, 2);
                    break;
    
                case 'MES':
                    $this->cantidad = number_format($endDate->diffInHours($initDate) / 24 / 30, 2);
                    break;
            }
        }
    }

    public function model(){
        return $this->morphTo();
    }

    public function ingresos_propietario(){
        return $this->morphMany(IngresoPropietario::class, 'model');
    }

    public function recibe(){
        return $this->belongsTo(User::class, 'user_recibido');
    }

    public function retorno_format(){
        return Carbon::parse($this->retorno())->format('M/d/Y h:i A');
    }

    public function fecha_recibido_format(){
        return Carbon::parse($this->fecha_recibido)->format('M/d/Y h:i A');
    }

    public function tiempo_renta(){
        $value = $this->cantidad . ' ' . $this->tipo_renta;
        $value .= $this->cantidad > 1 ? ($this->tipo_renta == 'MES' ? 'ES' : 'S') : '';
        return $value;
    }

    public function saldo_pendiente(){
        return $this->importe() - $this->pagado;
    }


}
