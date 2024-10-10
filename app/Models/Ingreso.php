<?php

namespace App\Models;

use App\Http\Traits\HasCancelable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Ingreso extends BaseModel
{
    use HasFactory, HasCancelable;

    protected $table = 'ingresos';

    protected $fillable = [
        'tipo',
        'sucursal_id',
        'model_id',
        'model_type',
        'forma_pago',
        'monto',
        'referencia',
        'pago',
        'cambio',
        'comentarios',
        'canceled_by',
        'canceled_at',
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

    public function fecha_format(){
        return Carbon::parse($this->created_at)->format('M/d/Y h:i A');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function model(){
        return $this->morphTo();
    }

    public function folio_de(){
        return Str::upper(Str::replace('App\\Models\\', '', $this->model_type));
    }

    public function cancelado_por(){
        return $this->belongsTo(User::class, 'canceled_by');
    }

    public function fecha_cancelacion(){
        return Carbon::parse($this->canceled_at)->format('M/d/Y h:i A');
    }
}
