<?php

use App\Http\Controllers\bases\FacturacionBaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivewireController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ComplementoController;
use App\Http\Controllers\PdfController;
use App\Models\Factura;

Route::middleware(['logged'])->group(function () {
    //FACTURAS
    // Route::get('/crear_factura/{model}/{id}', [App\Http\Controllers\LivewireController::class, 'CrearFactura'])->name('facturas.crear');
    Route::get('/crear-factura', [LivewireController::class, 'CrearFactura'])->name('facturas.crear');
    Route::get('/facturas', function(){
        return view('livewire.facturas.catalogo-facturas.index');
    });
    Route::get('/facturacion/emisores', [LivewireController::class, 'emisores'])->name('facturacion.emisores');

    Route::get('factura/{factura}/complementos', function(Factura $factura){
        return view('livewire.facturas.crear_complemento.index', compact('factura'));
    });



    ///POST
    Route::post('/facturacion/timbrar_factura', [FacturaController::class, 'GenerarFactura']);
    Route::post('/facturacion/timbrar_complemento', [ComplementoController::class, 'GenerarComplemento']);
    Route::post('/facturacion/cancelar_factura', [FacturacionBaseController::class, 'CancelarFactura']);


    Route::get('/timbrar_factura/{factura_temporal}', [App\Http\Controllers\FacturaController::class, 'timbrar_factura']);


    Route::get('/facturacion/ver_pdf/{factura}', [FacturaController::class, 'factura_pdf'])->name('pdf.factura_pdf');
    Route::get('/complementos/ver_pdf/{complemento}', [ComplementoController::class, 'complemento_pago_pdf'])->name('pdf.complemento_pago_pdf');
    
    Route::get('/facturacion/xml/{factura}', [FacturaController::class, 'downloadXML']);
    Route::get('/complementos/xml/{complemento}', [ComplementoController::class, 'downloadXML']);
});
