<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class Telefono extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'model_type',
        'tipo',
        'numero',
    ];

    public function model(){
        return $this->morphTo();
    }
}
