<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class RentaRegistroTemporal extends BaseModel
{
    use HasFactory;

    protected $table = 'renta_registros_temporales';

    protected $fillable = [
        'renta_temporal_id',
        'model_type',
        'model_id',
        'unidades',
        'tipo_renta',
        'cantidad',
        'precio',
        'pagado',
        'horometro_inicio',
    ];

    public function importe(){
        return $this->cantidad * $this->precio;//DEUDA
    }

    public function model(){
        return $this->morphTo();
    }

    public function retorno(){
        $fecha = Carbon::now();
        switch ($this->tipo_renta) {
            case 'HORA':
                $fecha->addHours($this->cantidad);
                break;

            case 'DIA':
                $fecha->addDays($this->cantidad);
                break;

            case 'SEMANA':
                $fecha->addDays($this->cantidad * 7);
                break;

            case 'MES':
                $fecha->addDays($this->cantidad * 30);
                break;
        }
        return $fecha; //->format('M/d/Y h:i A');
    }

    public function descripcion(){
        if($this->model_type == Equipo::class){
            return $this->model->descripcion;
        }
        if($this->model_type == Producto::class){
            return $this->model->descripcion;
        }
        if($this->model_type == Traslado::class){
            return "TRASLADO " . $this->tipo_renta . ": " . $this->model->destino;
        }
    }

    public function setPagadoAttribute($value)
    {
        if(!is_numeric($value)){
            $this->attributes['pagado'] = 0;
            return;
        }
        $this->attributes['pagado'] = $value;
    }

    public function retorno_format(){
        return Carbon::parse($this->retorno())->format('M/d/Y h:i A');
    }

    public function addQty($qty){
        $this->cantidad + $qty;
        $this->save();
    }
}
