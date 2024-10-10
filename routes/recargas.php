<?php

use App\Http\Controllers\RecargasController;
use Illuminate\Support\Facades\Route;

Route::middleware(['logged'])->prefix('recargas')->group(function () {
    
    Route::get('/', function(){
        return view('livewire.recargas.realizar_recarga.index');
    })->name('recargas');

    Route::get('/historial', function(){
        return view('livewire.recargas.historial.index');
    })->name('recargas.historial');


    //SERVICES
    Route::get('/get-products', [RecargasController::class, 'GetProducts']);
    Route::get('/get-carriers', [RecargasController::class, 'GetCarriers']);
    Route::post('/realizar_recarga', [RecargasController::class, 'PostRecarga']);



});

