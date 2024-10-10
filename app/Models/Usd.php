<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class Usd extends BaseModel
{
    use HasFactory;

    protected $table = 'usd';

    protected $fillable = [
        'cotizacion',
        'updated_by',
    ];

    public function modificado_por(){
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function updated_at_format(){
        return Carbon::parse($this->updated_at)->format('M/d/Y h:i A');
    }
}
