<?php

namespace App\Models\shared;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class CancelableModel extends BaseModel
{
    use HasFactory;

    public function cancelado_por(){
        return $this->belongsTo(User::class, 'canceled_by');
    }

    public function getFechaCancelacionAttribute(){
        return Carbon::parse($this->canceled_at)->format('M/d/Y h:i A');
    }

    public function getActiveAttribute(){
        if(isset($this->canceled_at)){
            return false;
        }
        return true;
    }

    public function SoftDelete(){
        $this->canceled_at = Carbon::now();
        $this->canceled_by = Auth::user()->id;
        return $this->save();
    }


}
