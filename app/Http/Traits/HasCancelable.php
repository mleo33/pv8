<?php


namespace App\Http\Traits;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait HasCancelable {

    public function cancel(){
        if($this->canceled_at == null){
            $this->canceled_at = now();
            $this->canceled_by = Auth::id();
            return $this->save();
        }
        return false;
    }

    public function user_cancel(){
        return $this->belongsTo(User::class, 'canceled_by');
    }

    public function getIsCanceledAttribute(){
        return $this->canceled_at != null;
    }

    public function getCanceledAtFormatAttribute(){
        return $this->canceled_at == null ? '' : Carbon::parse($this->canceled_at)->format('M/d/Y h:i A');
    }
}