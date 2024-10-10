<?php


namespace App\Http\Traits;

use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

trait VentaTrait {

    public function viewRegistros($id){
        $this->focusElement = Venta::findOrFail($id);
        $this->emit('showModal', '#mdlSaleDetails');
    }
}