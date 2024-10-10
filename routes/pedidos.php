<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::middleware(['logged'])->prefix('pedidos')->group(function () {
    
    Route::get('/', function(){
        return view('livewire.pedido.catalogo-pedidos.index');
    });

    Route::get('/crear-pedido', function(){
        return view('livewire.pedido.crear-pedido.index');
    });

    Route::get('/pdf/{pedido}', [PdfController::class, 'pedido_pdf']);

    
});

