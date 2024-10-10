<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class Categoria extends BaseModel
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
    ];
}
