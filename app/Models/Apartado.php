<?php

namespace App\Models;

use App\Models\shared\CancelableModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Apartado extends CancelableModel
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'sucursal_id',
        'cliente_id',
        'vence',
        'canceled_at',
        'canceled_by',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $user = Auth::user();
            $model->usuario_id = $user->id;
            $model->sucursal_id = $user->sucursal_default;
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function conceptos(){
        return $this->hasMany(ApartadoConcepto::class, 'apartado_id');
    }

    public function ingresos(){
        return $this->morphMany(Ingreso::class, 'model');
    }

    public function getPagadoAttribute(){
        return $this->ingresos->sum('monto');
    }

    public function pagado(){
        return $this->ingresos->sum('monto');
    }

    public function getSaldoAttribute(){
        return $this->importe - $this->pagado;
    }

    public function getVenceFormatAttribute(){
        return Carbon::parse($this->vence)->format('M/d/Y');
    }

    public function getImporteAttribute(){
        if($this->conceptos){
            return $this->conceptos->reduce(function($carry, $item){
                return $carry + $item->importe;
            });
        }
        return 0;
    }

    public function getTotalProductosAttribute(){
        if($this->conceptos){
            return $this->conceptos->reduce(function($carry, $item){
                return $carry + $item->cantidad;
            });
        }
        return 0;
    }

    public function getFaltaParaVencerAttribute(){
        $days = Carbon::parse($this->vence)->diff(Carbon::today())->days;
        $um = $days == 1 ? 'Dia' : 'Días';
        return "{$days} {$um}";
    }

    public function getFactorIvaAttribute(){
        return $this->tasa_iva / 100;
    }

    public function getSubtotalAttribute(){
        if($this->conceptos){
            return $this->conceptos->reduce(function($carry, $item){
                return $carry + $item->importe;
            });
        }
        return 0;
    }

    public function getIvaAttribute(){
        return $this->subtotal * $this->factor_iva;
    }

    public function getTotalAttribute(){
        return $this->subtotal + $this->iva;
    }


}
