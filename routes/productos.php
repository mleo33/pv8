<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivewireController;

Route::middleware(['logged'])->prefix('productos')->group(function () {
    
    Route::get('/', [LivewireController::class, 'productos'])->name('productos');
    
    Route::get('/claves_productos', function(){
        return view('livewire.claves_productos.index');
    })->name('productos.claves_productos');
    
    Route::get('/claves_unidades', function(){
        return view('livewire.claves_unidades.index');
    })->name('productos.claves_unidades');
});

