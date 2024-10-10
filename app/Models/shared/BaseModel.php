<?php

namespace App\Models\shared;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public function getIdPaddyAttribute(){
        return str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function fecha_format(){
        return Carbon::parse($this->created_at)->format('M/d/Y h:i A');
    }

    public function getFechaFormatAttribute(){
        return Carbon::parse($this->created_at)->format('M/d/Y h:i A');
    }

    public function getFechaCreacionAttribute(){
        return Carbon::parse($this->created_at)->format('M/d/Y h:i A');
    }

    public function getActiveAttribute(){
        if(isset($this->canceled_at)){
            return false;
        }
    }
}
