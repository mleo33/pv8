<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivewireController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RentaController;
use App\Models\Venta;

Route::middleware(['logged'])->group(function () {
    
    //REPORTES
    Route::get('/venta/{venta}', function(Venta $venta){
        return view('livewire.ventas.ver-venta.index', compact('venta'));
    });



    Route::get('/ver-ventas', [LivewireController::class, 'verVentas'])->name('ver-ventas');
    Route::get('/ver-rentas', [LivewireController::class, 'verRentas'])->name('ver-rentas');
    Route::get('/reportes/ventas', [LivewireController::class, 'reporteVentas'])->name('reportes.ventas');
    Route::post('/reporte_ventas', [PdfController::class, 'reporteVentas'])->name('pdf.reporte_ventas');
    Route::get('/reportes/rentas', [LivewireController::class, 'reporteRentas'])->name('reportes.rentas');
    Route::post('/reporte_rentas', [PdfController::class, 'reporteRentas'])->name('pdf.reporte_rentas');
    Route::get('/reportes/rentas_pendientes', [LivewireController::class, 'reporteRentasPendientes'])->name('reportes.rentas_pendientes');
    Route::post('/reporte_rentas_pendientes', [PdfController::class, 'reporteRentasPendientes'])->name('pdf.reporte_rentas_pendientes');
    Route::get('/reportes/facturas', [LivewireController::class, 'reporteFacturas'])->name('reportes.facturas');
    Route::post('/reporte_facturas', [PdfController::class, 'reporteFacturas'])->name('pdf.reporte_facturas');
    Route::get('/reportes/articulos_vendidos', [LivewireController::class, 'reporteArticulosVendidos'])->name('reportes.articulos_vendidos');
    Route::post('/reporte_articulos_vendidos', [PdfController::class, 'reporteArticulosVendidos'])->name('pdf.reporte_articulos_vendidos');
    Route::get('/rentas/prox_vencimiento', [RentaController::class, 'RentasProxVencimiento'])->name('rentas.prox_vencimiento');
    Route::get('/pdf/corte/{sucursal}/{usuario}/{start}/{end}', [PdfController::class, 'corte'])->name('pdf.corte');;
});