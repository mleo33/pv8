<?php

use App\Http\Controllers\FacturaController;
use App\Http\Resources\TicketApartado\TicketApartadoResource;
use App\Http\Resources\TicketVenta\TicketVentaResource;
use App\Models\Apartado;
use App\Models\Factura;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('api-tickets')->group(function () {
    
    Route::get('/venta', function(Request $request){
        $id = $request->input('id');
        return new TicketVentaResource(Venta::FindOrFail($id));
    });

    Route::get('/ingreso', function(Request $request){
        $id = $request->input('id');
    });

    Route::get('/factura', function(Request $request){
        $id = $request->input('id');
        $resource = FacturaController::getXmlToPDFResource(Factura::FindOrFail($id));
        return $resource;
    });

    Route::get('/apartado', function(Request $request){
        $id = $request->input('id');
        return new TicketApartadoResource(Apartado::FindOrFail($id));
    });

    Route::get('/devolucion', function(Request $request){
        $id = $request->input('id');
    });

});

