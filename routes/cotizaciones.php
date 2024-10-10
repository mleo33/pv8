<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

Route::middleware(['logged'])->prefix('cotizaciones')->group(function () {
    
    Route::get('/', function(){
        return view('livewire.cotizacion.catalogo-cotizaciones.index');
    });

    Route::get('/crear-cotizacion', function(){
        return view('livewire.cotizacion.crear-cotizacion.index');
    });

    Route::get('/{id}', function(){
        
    });

    Route::get('/pdf/{cotizacion}', [PdfController::class, 'cotizacion_pdf']);

});

