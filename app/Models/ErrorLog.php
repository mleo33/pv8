<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Illuminate\Support\Facades\Auth;

class ErrorLog extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'error',
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
}
