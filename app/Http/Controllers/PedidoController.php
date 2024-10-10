<?php

namespace App\Http\Controllers;

use App\Mail\PedidoMail;
use App\Models\ErrorLog;
use App\Models\Pedido;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PedidoController extends Controller
{
    public static function enviarCorreo(Pedido $pedido, $message, $correos = null){
        try{
            $mails = $correos == null ? $pedido->proveedor->correo : $correos;
            $mailable = new PedidoMail($pedido, $message);
            Mail::to($mails)->send($mailable);
            return true;
        }
        catch(Exception $e){
            ErrorLog::create(['titulo' => 'EnviarCorreo', 'error' => $e->getMessage()]);
            throw $e;
        }
    }
}
