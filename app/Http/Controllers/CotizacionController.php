<?php

namespace App\Http\Controllers;

use App\Mail\CotizacionMail;
use App\Models\ErrorLog;
use App\Models\Cotizacion;
use Exception;
use Illuminate\Support\Facades\Mail;

class CotizacionController extends Controller
{
    public static function enviarCorreo(Cotizacion $cotizacion, $message, $correos = null){
        try{
            $mails = $correos == null ? $cotizacion->cliente->correo : $correos;
            $mailable = new CotizacionMail($cotizacion, $message);
            Mail::to($mails)->send($mailable);
            return true;
        }
        catch(Exception $e){
            ErrorLog::create(['titulo' => 'EnviarCorreo', 'error' => $e->getMessage()]);
            throw $e;
        }
    }
}
