<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\RentModel;

class Renta extends RentModel
{
    use HasFactory;

    protected $table = 'rentas';

    protected $fillable = [
        'fecha',
        'usuario_id',
        'sucursal_id',
        'cliente_id',
        'entidad_fiscal_id',
        'canceled_at',
        'canceled_by',
    ];

    public static function equipos_pendientes(){
        return RentaRegistro::where('fecha_recibido', null)
        ->where('model_type', 'App\Models\Equipo')->get();
    }

    public static function equipos_proximo_vencimiento(){
        $date = new \DateTime('now + 1 day');

        return Self::equipos_pendientes()->filter(function($item) use ($date){
            if($item->tipo_renta == 'HORA'){
                return $item->retorno() < now();
            }else{
                return $item->retorno() < $date;
            }
        });
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function entidad_fiscal(){
        return $this->belongsTo(EntidadFiscal::class);
    }

    public function registros(){
        return $this->hasMany(RentaRegistro::class, 'renta_id');
    }

    public function equipos(){
        return $this->hasMany(RentaRegistro::class, 'renta_id')->where(['model_type' => Equipo::class]);
    }

    public function traslados(){
        return $this->hasMany(RentaRegistro::class, 'renta_id')->where(['model_type' => Traslado::class]);
    }


    public function anticipo(){
        return $this->ingresos->where('tipo', 'ANTICIPO')->sum('monto');
    }

    //UNO A MUCHOS POLIMORFICA
    public function ingresos(){
        return $this->morphMany(Ingreso::class, 'model');
    }

    public function facturas(){
        return $this->morphMany(Factura::class, 'model');
    }

    public function saldo_pendiente(){
        return $this->total() - $this->ingresos->sum('monto');
    }

    public function valor_total_equipos(){
        $usdmxn = Usd::find(1)->cotizacion;
        return $this->equipos->reduce(function($carry, $elem) use ($usdmxn){
            $valor_equipo = $elem->model->valor_total();
            if($elem->model->moneda == 'USD'){
                $valor_equipo = $valor_equipo * $usdmxn;
            }
            return $carry + ($valor_equipo * $elem->unidades);
        });
    }

    public function activa(){
        if(isset($this->canceled_at)){
            return false;
        }
        else{
            return ($this->saldo_pendiente() > 0) || ($this->equipos->where('recibido', 0)->count() > 0);            
        }
    }

    public function fecha_format(){
        return Carbon::parse($this->fecha)->format('M/d/Y h:i A');
    }

    public function cancelado_por(){
        return $this->belongsTo(User::class, 'canceled_by');
    }

    public function fecha_cancelacion(){
        return Carbon::parse($this->canceled_at)->format('M/d/Y h:i A');
    }

    public function comentarios(){
        return $this->morphMany(Comentario::class, 'model');
    }

}
