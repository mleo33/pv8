<?php

namespace App\Models;

use App\Http\Traits\HasCancelable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\SaleModel;
use Illuminate\Support\Facades\Auth;

class Venta extends SaleModel
{
    use HasFactory, HasCancelable;

    protected $table = 'ventas';

    protected $fillable = [
        'usuario_id',
        'sucursal_id',
        'cliente_id',
        'tasa_iva',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $user = Auth::user();
            $model->usuario_id = $user->id;
            $model->sucursal_id = $user->sucursal_default;
            $model->tasa_iva = $user->sucursal->tasa_iva;
        });
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function registros()
    {
        return $this->hasMany(VentaRegistro::class, 'venta_id');
    }

    public function apartado()
    {
        return $this->hasOne(Apartado::class, 'venta_id');
    }

    public function getIngresosAttribute(){
        return $this->ingresos_ventas->merge($this->ingresos_apartados);
    }

    public function ingresos_ventas(){
        return $this->morphMany(Ingreso::class, 'model');
    }

    public function getIngresosApartadosAttribute(){
        if($this->apartado){
            return $this->apartado->ingresos;
        }
        return [];
    }

    public function facturas(){
        return $this->morphMany(Factura::class, 'model');
    }

    public function comentarios(){
        return $this->morphMany(Comentario::class, 'model');
    }

    public function fecha_format(){
        return Carbon::parse($this->created_at)->format('M/d/Y h:i A');
    }

    public function getPagadoAttribute(){
        return $this->ingresos->sum('monto');
    }

    public function getSaldoAttribute(){
        return $this->total() - $this->pagado;
    }

    public function saldo_pendiente(){
        return $this->saldo;
    }

    public function getActiveAttribute(){
        if(isset($this->canceled_at)){
            return false;
        }
        return $this->saldo > 0;
    }

    public function cancelar(){
        foreach ($this->ingresos as $elem) {
            $elem->cancel();
        }
        foreach ($this->registros as $elem) {
            $elem->cancel();
        }
        $this->cancel();
    }

    public function getTotalActualAttribute(){
        if($this->registros){
            return $this->registros->reduce(function($carry, $item){
                $precioOriginal = $item->producto?->current_inventory->precio ?? 0;
                $importe = $item->cantidad * $precioOriginal;
                return $carry + $importe;
            });
        }
        return 0;
    }
}
