<?php

use App\Http\Controllers\LivewireController;
use App\Http\Livewire\ViewTicketSupportLw;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Mail;
use App\Mail\FacturaMailable;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// MAIN
Route::get('/print', [App\Http\Controllers\HomeController::class, 'print'])->name('print');

Auth::routes();

// MODULES
Route::middleware(['logged'])->group(function () 
{
    Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('root');

    Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'inicio'])->name('inicio');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
    //CATALOGOS
    Route::get('/clientes', [LivewireController::class, 'clientes'])->name('clientes');
    Route::get('/marcas', [LivewireController::class, 'marcas'])->name('marcas');
    Route::get('/familias', [LivewireController::class, 'familias'])->name('familias');
    Route::get('/categorias', [LivewireController::class, 'categorias'])->name('categorias');
    Route::get('/sucursales', [LivewireController::class, 'sucursales'])->name('sucursales');
    
    Route::get('/equipos', [LivewireController::class, 'equipos'])->name('equipos');
    Route::get('/traslados', [LivewireController::class, 'traslados'])->name('traslados');
    Route::get('/proveedores', [LivewireController::class, 'proveedores'])->name('proveedores');
    Route::get('/ingresos', [LivewireController::class, 'ingresos'])->name('ingresos');
    Route::get('/egresos', [LivewireController::class, 'egresos'])->name('egresos');
    Route::get('/corte', [LivewireController::class, 'corte'])->name('corte');
    Route::get('/soporte', [LivewireController::class, 'TicketsSoporte'])->name('soporte');
    Route::get('/soporte/crear_ticket', [LivewireController::class, 'CrearTicketsSoporte']);
    Route::get('/ver_ticket_soporte/{id}', [LivewireController::class, 'ViewTicketSoporte'])->name('ViewTicketSoporte');

    //MODULOS
    Route::get('/ventas', [App\Http\Controllers\LivewireController::class, 'ventas'])->name('ventas');

    //CONFIG
    Route::get('/usuarios', [App\Http\Controllers\LivewireController::class, 'usuarios'])->middleware(['can:ver-usuarios,editar-usuarios'])->name('usuarios');
    Route::get('/roles', [App\Http\Controllers\LivewireController::class, 'roles'])->name('roles');
    Route::get('/permisos', [App\Http\Controllers\LivewireController::class, 'permisos'])->name('permisos');
    Route::get('/usdmxn', [App\Http\Controllers\LivewireController::class, 'usdmxn'])->name('usdmxn');

    Route::get('/pdf/clientes', [App\Http\Controllers\PdfController::class, 'clientes'])->name('clientes.pdf');
    Route::get('/pdf/proveedores', [App\Http\Controllers\PdfController::class, 'proveedores'])->name('proveedores.pdf');
    Route::get('/clientes/{cliente}/edo_cta', [App\Http\Controllers\PdfController::class, 'cliente_edo_cta'])->name('clientes.edo_cta.pdf');

    Route::get('/printer', function(){
        return view('livewire.home.printer.view');
    });

});
