<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['logged'])->prefix('apartados')->group(function () {
    
    Route::get('/', function(){
        return view('livewire.apartado.catalogo-apartados.index');
    });
    
});

