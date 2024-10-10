<?php

namespace App\Models;

use App\Http\Traits\SaleComponentTrait;
use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Cotizacion extends BaseModel
{
    use HasFactory, SaleComponentTrait;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'usuario_id',
        'sucursal_id',
        'cliente_id',
        'tasa_iva',
        'vigencia',
        'comentarios',
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
    
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function conceptos(){
        return $this->hasMany(CotizacionRegistro::class, 'cotizacion_id');
    }

    public function getFechaFormatAttribute()
    {
        return ucfirst(Carbon::parse($this->created_at)->translatedFormat('F/d/Y h:i A'));
    }

}
