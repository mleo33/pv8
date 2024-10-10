<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Illuminate\Support\Str;

class Egreso extends BaseModel
{
    use HasFactory;

    protected $table = 'egresos';

    protected $fillable = [
        'usuario_id',
        'tipo',
        'model_id',
        'model_type',
        'forma_pago',
        'concepto',
        'monto',
        'canceled_by',
        'canceled_at',
    ];

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
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