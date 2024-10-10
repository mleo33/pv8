<?php

namespace App\Http\Controllers;

use App\Models\Renta;
use Illuminate\Http\Request;

class LivewireController extends Controller
{
    public function categorias(){
        return view('livewire.categorias.index');
    }

    public function clientes(){
        return view('livewire.clientes.index');
    }

    public function familias(){
        return view('livewire.familias.index');
    }

    public function marcas(){
        return view('livewire.marcas.index');
    }

    public function productos(){
        return view('livewire.productos.index');
    }

    public function equipos(){
        return view('livewire.equipos.index');
    }

    public function traslados(){
        return view('livewire.traslados.index');
    }

    public function proveedores(){
        return view('livewire.proveedores.index');
    }

    public function sucursales(){
        return view('livewire.sucursales.index');
    }

    public function emisores(){
        return view('livewire.emisores.index');
    }

    public function ventas(){
        return view('livewire.ventas.pos.index');
    }

    public function rentas(){
        return view('livewire.rentas.crear_renta.index');
    }

    // public function CrearFactura($model, $folio){
    //     return view('livewire.facturas.crear_factura.index', ['model' => $model, 'folio' => $folio]);
    // }

    public function CrearFactura(){
        return view('livewire.facturas.crear_factura.index');
    }

    public function administrar_renta(Renta $renta){
        return view('livewire.rentas.admin.index', compact('renta'));
    }

    public function usuarios(){
        return view('livewire.usuarios.index');
    }

    public function roles(){
        return view('livewire.roles.index');
    }

    public function permisos(){
        return view('livewire.permisos.index');
    }

    public function verVentas(){
        // return view('livewire.ventas.reportes.index');
        return view('livewire.ventas.catalogo-ventas.index');

    }

    public function verRentas(){
        return view('livewire.rentas.reportes.index');
    }

    public function verFacturas(){
        return view('livewire.facturas.reportes.index');
    }

    public function ingresos(){
        return view('livewire.ingresos.index');
    }

    public function egresos(){
        return view('livewire.egresos.index');
    }

    public function usdmxn(){
        return view('livewire.usdmxn.index');
    }

    public function corte(){
        return view('livewire.corte.index');
    }

    //REPORTES
    public function reporteVentas(){
        return view('livewire.ventas.reporte-ventas.index');
    }

    public function reporteRentas(){
        return view('livewire.reportes.reporte-rentas.index');
    }

    public function reporteRentasPendientes(){
        return view('livewire.reportes.reporte-rentas-pendientes.index');
    }

    public function reporteFacturas(){
        return view('livewire.reportes.reporte-facturas.index');
    }

    public function reporteArticulosVendidos(){
        return view('livewire.reportes.reporte-articulos-vendidos.index');
    }

}
