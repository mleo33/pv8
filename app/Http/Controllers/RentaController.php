<?php

namespace App\Http\Controllers;

use App\Models\Renta;
use Illuminate\Http\Request;

class RentaController extends Controller
{
    public function RentasProxVencimiento(){
        return view('models.renta.prox_vencimiento',[
            'equipos' => Renta::equipos_proximo_vencimiento(),
        ]);
    }
}
