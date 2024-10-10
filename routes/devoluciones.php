<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['logged'])->prefix('devoluciones')->group(function () {
    
    Route::get('/', function(){
        return view('livewire.devolucion.catalogo-devoluciones.index');
    });
    
});

