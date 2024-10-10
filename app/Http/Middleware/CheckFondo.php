<?php

namespace App\Http\Middleware;

use App\Models\Ingreso;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CheckFondo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $suc = $user->sucursal_default;
        $date = Carbon::today()->format('Ymd');
        $key = "FONDO-{$date}-{$suc}-{$user->id}";

        if(Cache::has($key)){
            return $next($request);
        }
        return redirect('/capturar-fondo');
    }
}
