<?php

namespace App\Models;

use App\Models\shared\CancelableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Pedido extends CancelableModel
{
    use HasFactory;

    protected $fillable = [
        // 'usuario_id',
        // 'sucursal_id',
        'proveedor_id',
        'tasa_iva',
        'estatus',
        'comentarios',
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

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function conceptos(){
        return $this->hasMany(PedidoConcepto::class);
    }

    public function getTotalProductosAttribute(){
        if($this->conceptos){
            return $this->conceptos->reduce(function($carry, $item){
                return $carry + $item->cantidad;
            });
        }
        return 0;
    }

    public function getEstatusRecibidoAttribute(){
        $cant = $this->conceptos->sum('cantidad');
        $recibidos = $this->conceptos->sum('cantidad_recibida');

        if($recibidos == 0){
            return $this->estatus;
        }
        else if($recibidos == $cant){
            return 'RECIBIDO';
        }
        else{
            return 'PARCIALMENTE RECIBIDO';
        }
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
