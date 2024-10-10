<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Illuminate\Support\Facades\DB;

class Cliente extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'correo',
        'limite_credito',
        'dias_credito',
        'puntos',
        'comentarios',
    ];

    protected $attributes = [
        'dias_credito' => 30,
        'limite_credito' => 0,
    ];

    public function rentas(){
        return $this->hasMany(Renta::class);
    }

    // public function rentas_activas(){
    //     return $this->hasMany(Renta::class)->where('canceled_at', null);
    // }

    public function ventas(){
        return $this->hasMany(Venta::class);
    }

    public function ventas_activas(){
        return $this->hasMany(Venta::class)->where('canceled_at', null);
    }

    public function getVentasPendientesAttribute(){
        return $this->ventas_activas->where('active', true);
    }

    public function referencias(){
        return $this->hasMany(ReferenciaCliente::class);
    }

    public function telefonos(){
        return $this->morphMany(Telefono::class, 'model');
    }

    public function entidades_fiscales(){
        return $this->morphMany(EntidadFiscal::class, 'model');
    }

    public function getPendienteRentaAttribute(){
        if($this->ventas_activas){
            $pendiente = $this->ventas_activas->reduce(function($carry, $item){
                $pendiente = $item->saldo_pendiente();
                return $carry + ($pendiente <= 0 ? 0 : $pendiente);
            });
            return $pendiente;
        }
        return 0;
    }

    public function getPendienteVentaAttribute(){
        if($this->ventas_activas){
            $pendiente = $this->ventas_activas->reduce(function($carry, $item){
                $pendiente = $item->saldo;
                return $carry + ($pendiente <= 0 ? 0 : $pendiente);
            });
            return $pendiente;
        }
        return 0;
    }

    public function credito_disponible(){

        return $this->limite_credito - $this->pendiente_venta; // - $this->pendiente_renta
    }

    public function rentas_activas(){
        return $this->hasMany(Renta::class)
        ->select('rentas.*',
            DB::raw('(Select count(recibido) from renta_registros where renta_id = rentas.id and recibido = 0) as EquipoFaltante'),
            DB::raw('(Select sum(unidades * cantidad * precio) from renta_registros where renta_id = rentas.id) as MontoTotal'),
            DB::raw('ifnull(sum(ingresos.monto), 0) as Pagado'))
        ->leftjoin('ingresos', function($join){
            $join->on('ingresos.model_id', '=', 'rentas.id')
            ->where('ingresos.model_type', '=', Renta::class);
        })
        // ->where(['canceled_at' => ])
        ->havingRaw('(Pagado < MontoTotal) or EquipoFaltante > 0')
        ->groupBy('rentas.id');
    }

    public function sumarPuntos($puntos){
        $this->puntos += intval($puntos);
        $this->save();
    }
}
