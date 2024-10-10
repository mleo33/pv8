<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendMail extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'title',
        'message',
        'model_id',
        'model_type',
        'from',
        'to',
        'sent',
    ];

    public function model(){
        return $this->morphTo('model');
    }




}
