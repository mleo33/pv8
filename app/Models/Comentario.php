<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class Comentario extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'tipo',
        'mensaje',
        'model_id',
        'model_type',
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function model(){
        return $this->morphTo();
    }
}
