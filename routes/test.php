<?php

use App\Models\Producto;
use App\Models\VentaRegistro;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    $t = Producto::findOrFail(1);
    
    return $t->current_stock;
});

Route::get('/cache/clear', function () {
    return Cache::flush();
});

Route::get('/cache/{key}', function ($key) {
    return Cache::get($key);
});

