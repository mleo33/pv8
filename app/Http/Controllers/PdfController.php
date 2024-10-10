<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Complemento;
use App\Models\Proveedor;
use App\Models\Renta;
use App\Models\Cotizacion;
use App\Models\Factura;
use App\Models\Pedido;
use App\Models\Sucursal;
use App\Models\User;
use App\Models\Venta;
use App\Models\VentaRegistro;
use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{
    public function categorias(){
        return view('pdf.categorias');
    }

    public function clientes(){
        $clientes = Cliente::orderBy('id', 'desc')->get();
        $pdf = PDF::loadView('pdf.clientes', compact('clientes'));
        $pdf->setPaper('A4', 'Landscape');
        return $pdf->stream('Clientes_Reporte.pdf');
    }

    public function familias(){
        return view('pdf.familias');
    }

    public function marcas(){
        return view('pdf.marcas');
    }

    public function productos(){
        return view('pdf.productos');
    }

    public function proveedores(){
        $proveedores = Proveedor::orderBy('id', 'desc')->get();
        $pdf = PDF::loadView('pdf.proveedores', compact('proveedores'));
        $pdf->setPaper('A4', 'Landscape');
        return $pdf->stream('Proveedores_Reporte.pdf');
    }

    public function sucursales(){
        return view('pdf.sucursales');
    }

    public function ventas(){
        return view('pdf.ventas');
    }

    public static function corte($sucursal, $usuario_id, $startDate, $endDate){

        // $startDate = $startDate . ' 00:00:00';

        $ingresos = \App\Models\Ingreso::whereBetween('created_at', [$startDate, ($endDate . ' 23:59:59')])->where('canceled_at', null)->get();
        $egresos = \App\Models\Egreso::whereBetween('created_at', [$startDate, ($endDate . ' 23:59:59')])->where('canceled_at', null)->get();
        $i_ventas = \App\Models\Ingreso::where(['model_type' => Venta::class])->whereBetween('created_at', [$startDate, ($endDate . ' 23:59:59')])->get();
        $conteoFisico = \App\Models\ConteoFisico::whereDate('created_at', $startDate)->get();

        $usuario = new User();
        if(intval($sucursal) > 0)
        {
            $ingresos = $ingresos->where('sucursal_id', $sucursal);
            $i_ventas = $i_ventas->where('sucursal_id', $sucursal);
            $egresos = $egresos->where('sucursal_id', $sucursal);
            $conteoFisico = $conteoFisico->where('sucursal_id', $sucursal);
            $sucursal = Sucursal::FindOrFail($sucursal);
        }

        if(intval($usuario_id) > 0)
        {
            $usuario = User::FindOrFail($usuario_id);
            $ingresos = $ingresos->where('usuario_id', $usuario_id);
            $i_ventas = $i_ventas->where('usuario_id', $usuario_id);
            $egresos = $egresos->where('usuario_id', $usuario_id);
            $conteoFisico = $conteoFisico->where('user_id', $usuario_id);
        }

        $i_ventas_f = $i_ventas->reject(function($elem, $key){
            return $elem->model->facturas->where('estatus', 'TIMBRADO')->count() == 0;
        });
        $i_ventas_nf = $i_ventas->reject(function($elem, $key){
            return $elem->model->facturas->where('estatus', 'TIMBRADO')->count() > 0;
        });

        $pdf = PDF::loadView('pdf.corte.corte_normal', compact('sucursal', 'conteoFisico', 'usuario', 'ingresos', 'egresos', 'i_ventas', 'i_ventas_f', 'i_ventas_nf', 'startDate', 'endDate'));
        $pdf->setPaper('A4', 'Landscape');
        return $pdf->stream('corte_caja.pdf');
    }

    public static function contrato_renta($id){
        $renta = Renta::findOrFail($id);
        $pdf = PDF::loadView('pdf.contrato_renta', compact('renta'));
        $pdf->setPaper('legal');
        return $pdf->stream('Proveedores_Reporte.pdf');
    }

    public function cliente_edo_cta(Cliente $cliente){
        $pdf = PDF::loadView('pdf.clientes.edo_cta', compact('cliente'));
        return $pdf->stream('edo_cta_'. $cliente->id .'.pdf');
    }

    //////////// F A C T U R A C I O N ////////////
    public static function factura_pdf(Factura $factura){

        $cfdi = FacturaController::getXmlToPDFResource($factura);        
        $pdf = PDF::loadView('pdf.facturacion.factura_pdf', ['cfdi' => collect($cfdi)]);
        $pdf->setPaper('A4');
        
        return $pdf->stream($factura->uuid . '.pdf');
    }

    public static function complemento_pago_pdf(Complemento $complemento){
        $xml = $complemento->xml;
        $xml = simplexml_load_string($xml);
        $pdf = PDF::loadView('pdf.facturacion.factura_pdf', compact('factura', 'xml'));
        $pdf->setPaper('A4', 'Landscape');
        return $pdf->stream($complemento->uuid . '.pdf');
    }


    //////////// R E P O R T E S ////////////
    public function reporteVentas(){
        $start_date = request('start_date');
        $end_date = request('end_date');
        $user_id = request('user_id');
        $sucursal_id = request('sucursal_id');

        $ventas = Venta::OrderBy('id', 'asc')->whereBetween('created_at', [$start_date, ($end_date . ' 23:59:59')]);
        if($sucursal_id != 0){
            $ventas = $ventas->where('sucursal_id', $sucursal_id);
        }
        if($user_id != 0){
            $ventas = $ventas->where('usuario_id', $user_id);
        }
        $ventas = $ventas->get();
        

        $pdf = PDF::loadView('pdf.reportes.ventas_pdf', compact('ventas', 'start_date', 'end_date', 'user_id', 'sucursal_id'));
        return $pdf->stream('reporte_ventas' . date('Y-M-d-H-i') . 'pdf');
    }

    public function reporteRentas(){
        $start_date = request('start_date');
        $end_date = request('end_date');
        $user_id = request('user_id');
        $sucursal_id = request('sucursal_id');

        $rentas = Renta::OrderBy('id', 'asc')->whereBetween('fecha', [$start_date, ($end_date . ' 23:59:59')]);
        if($sucursal_id != 0){
            $rentas = $rentas->where('sucursal_id', $sucursal_id);
        }
        if($user_id != 0){
            $rentas = $rentas->where('usuario_id', $user_id);
        }
        $rentas = $rentas->get();
        

        $pdf = PDF::loadView('pdf.reportes.rentas_pdf', compact('rentas', 'start_date', 'end_date', 'user_id', 'sucursal_id'));
        return $pdf->stream('reporte_rentas_' . date('Y-M-d-H-i') . 'pdf');
    }

    public function reporteRentasPendientes(){
        $start_date = request('start_date');
        $end_date = request('end_date');
        $user_id = request('user_id');
        $sucursal_id = request('sucursal_id');

        $rentas = Renta::OrderBy('id', 'asc')->whereBetween('fecha', [$start_date, ($end_date . ' 23:59:59')]);
        if($sucursal_id != 0){
            $rentas = $rentas->where('sucursal_id', $sucursal_id);
        }
        if($user_id != 0){
            $rentas = $rentas->where('usuario_id', $user_id);
        }
        $rentas = $rentas->get();
        

        $pdf = PDF::loadView('pdf.reportes.rentas_pdf', compact('rentas', 'start_date', 'end_date', 'user_id', 'sucursal_id'));
        return $pdf->stream('reporte_rentas_' . date('Y-M-d-H-i') . 'pdf');
    }

    public function reporteFacturas(){
        $start_date = request('start_date');
        $end_date = request('end_date');
        $user_id = request('user_id');
        $sucursal_id = request('sucursal_id');

        $facturas = Factura::OrderBy('id', 'asc')->whereBetween('created_at', [$start_date, ($end_date . ' 23:59:59')]);
        if($sucursal_id != 0){
            $facturas = $facturas->where('sucursal_id', $sucursal_id);
        }
        if($user_id != 0){
            $facturas = $facturas->where('usuario_id', $user_id);
        }
        $facturas = $facturas->get();
        

        $pdf = PDF::loadView('pdf.reportes.facturas_pdf', compact('facturas', 'start_date', 'end_date', 'user_id', 'sucursal_id'));
        return $pdf->stream('reporte_rentas_' . date('Y-M-d-H-i') . 'pdf');
    }

    public function reporteArticulosVendidos(){
        $start_date = request('start_date');
        $end_date = request('end_date');
        $user_id = request('user_id');
        $sucursal_id = request('sucursal_id');

        $articulos = VentaRegistro::OrderBy('id', 'asc')->whereBetween('created_at', [$start_date, ($end_date . ' 23:59:59')]);
        if($sucursal_id != 0){
            $articulos = $articulos->whereHas('venta', function($q) use ($sucursal_id){
                $q->where('sucursal_id', '=', $sucursal_id);
            });
        }
        if($user_id != 0){
            $articulos = $articulos->whereHas('venta', function($q) use ($user_id){
                $q->where('usuario_id', '=', $user_id);
            });
        }
        $articulos = $articulos->get();
        

        $pdf = PDF::loadView('pdf.reportes.articulos_vendidos_pdf', compact('articulos', 'start_date', 'end_date', 'user_id', 'sucursal_id'));
        return $pdf->stream('reporte_articulos_vendidos_' . date('Y-M-d-H-i') . 'pdf');
    }

    public static function pedido_pdf(Pedido $pedido){
        $pdf = PDF::loadView('pdf.pedidos.pedido_pdf', compact('pedido'));
        $pdf->setPaper('A4');
        return $pdf->stream('Pedido_' . $pedido->id_paddy . '.pdf');
    }

    public static function cotizacion_pdf(Cotizacion $cotizacion){
        $pdf = PDF::loadView('pdf.cotizacion.cotizacion_pdf', compact('cotizacion'));
        $pdf->setPaper('A4');
        return $pdf->stream('Cotizacion_' . $cotizacion->id_paddy . '.pdf');
    }
}
