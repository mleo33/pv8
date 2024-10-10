<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Recarga;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RecargasController extends Controller
{
    public static function GetData(){
        if(!Cache::has('taecel_get_products')){

            $data = DB::table('taecel_credencials')->first();
            $client = new Client();
            $res = $client->post('https://taecel.com/app/api/getProducts', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'key' => $data->key,
                    'nip' => $data->nip,
                ]
            ]);

            Cache::put('taecel_get_products', json_decode($res->getBody()), 14400); // 14400 = 4 Hours
        }


        return Cache::get('taecel_get_products');
    }

    public static function GetProducts($idCarrier = 0){
        $data = self::GetData();

        return collect($data->data->productos)->reject(function($elem) use ($idCarrier){
            if($idCarrier > 0){
                return $elem->CarrierID != $idCarrier;
            }
            return false;
        });
    }

    public static function GetCarriers(){ 
        $data = self::GetData();

        if(!$data->success){
            return [];
        }

        return collect($data->data->carriers)->reject(function($elem){
            return $elem->BolsaID != 1;
        });
    }

    public function PostRecarga(Request $request){
        $categoria = $request->input('categoria');
        $compania = $request->input('compania');
        $producto = $request->input('codigo_producto');
        $referencia = $request->input('referencia');
        $monto = $request->input('monto');
        $pago = $request->input('pago');

        $data = DB::table('taecel_credencials')->first();

        $client = new Client();
        $res = $client->post('https://taecel.com/app/api/RequestTXN', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'key' => $data->key,
                'nip' => $data->nip,
                'producto' => $producto,
                'referencia' => $referencia,
                'monto' => $monto
            ]
        ]);

        $resRequestTXN = json_decode($res->getBody());
        $resRequestTXN->categoria = $categoria;
        $resRequestTXN->compania = $compania;
        $resRequestTXN->producto = $producto;
        $resRequestTXN->referencia = $referencia;
        $resRequestTXN->monto = $monto;
        $resRequestTXN->pago = $pago;

        if($resRequestTXN->success === true){

            $res = $client->post('https://taecel.com/app/api/StatusTXN', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'key' => $data->key,
                    'nip' => $data->nip,
                    'transID' => $resRequestTXN->data->transID,
                ]
            ]);

            $resStatusTXN = json_decode($res->getBody());
            
            self::GuardarRecarga($resRequestTXN, $resStatusTXN);

            return response()->json($resStatusTXN);
        }
        else{
            return response()->json($resRequestTXN);
        }

    }

    public function guardarRecarga($resRequestTXN, $resStatusTXN){
        $idRecarga = Recarga::create([
            'usuario_id' => Auth::user()->id,
            'sucursal_id' => Auth::user()->sucursal_default,
            'categoria' => $resRequestTXN->categoria,
            'compania' => $resRequestTXN->compania,
            'producto' => $resRequestTXN->producto,
            'referencia' => $resRequestTXN->referencia,
            'monto' => $resRequestTXN->monto,
            'trans_id' => $resRequestTXN->data->transID,
            'mensaje' => $resStatusTXN->message,
            'estatus' => trim(strtoupper($resStatusTXN->data->Status)),
            'folio' => $resStatusTXN->data->Folio,
            'response' => json_encode($resStatusTXN),
        ])->id;

        Ingreso::create([
            'tipo' => 'RECARGA_TAE',
            'usuario_id' => Auth::user()->id,
            'forma_pago' => "TAECEL",
            'monto' => $resRequestTXN->monto,
            'referencia' => '***',
            'model_type' => Recarga::class,
            'model_id' => $idRecarga,
            'pago' => $resRequestTXN->pago,
            'cambio' => 0,
        ]);

        return $idRecarga;
    }
}
