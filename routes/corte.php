<?php

use App\Models\AppConfig;
use App\Models\Corte;
use App\Models\Ingreso;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){

    Route::get('/capturar-fondo', function(){
        return view('livewire.corte.capturar-fondo.index');
    });

    Route::post('/capturar-fondo', function(Request $request){
        try{
            $user = User::findOrFail($request->user_id);
            $monto = floatval($request->monto);
            $sucursal_id = $user->sucursal_default;
            $date = Carbon::today()->format('Ymd');
            $key = "FONDO-{$date}-{$sucursal_id}-{$user->id}";
    
            if($monto > 0){
                Ingreso::create([
                    'tipo' => 'FONDO',
                    'sucursal_id' => $sucursal_id,
                    'forma_pago' => 'EFECTIVO',
                    'monto' => $monto,
                    'referencia' => $key,
                    'pago' => $monto,
                    'cambio' => 0,
                ]);
            }

            Cache::put($key, 'FONDO REALIZADO', 86400); // 24 horas

    
            return redirect('/inicio');
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    });

    Route::get('/cache/clear', function ($key) {
        return Cache::flush();
    });

    Route::get('/conteo-fisico', function(){
        return view('livewire.corte.capturar-conteo-fisico.index');
    });
    
    Route::get('/cache/{key}', function ($key) {
        // return Cache::getKeys($key);
        return 'hi';
    });

});

