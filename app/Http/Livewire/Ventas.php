<?php

namespace App\Http\Livewire;

use App\Models\Apartado;
use App\Models\ApartadoConcepto;
use App\Models\Cliente;
use App\Models\Ingreso;
use App\Models\MovimientoInventario;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaRegistro;
use App\Models\VentaTemporal;
use App\Models\VentaRegistroTemporal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Ventas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $selected_id;
    public $descuento = 0;

    public $venta_t;
    public $searchValueClientes;
    public $searchValueProductos;

    public Collection $formas_pago_venta;
    public Collection $formas_pago;
    public Collection $formas_pago_restantes;

    public $diasApartado;
    public $inputProduct;

    public $selectedRegistroTemporal;
    public $printEtiqueta = true;

    protected $rules = [
        'venta_t.comentarios' => 'string',
        'venta_t.PagoRequerido' => 'numeric',
        'venta_t.registros.*.precio' => 'numeric',

        'selectedRegistroTemporal.descuento' => 'numeric',
    ];

    protected $listeners = [
        'destroy' => 'destroy',
        'addQty' => 'addQty',
        'generarVentaPuntos' => 'generarVentaPuntos',
        'setProductByCode' => 'setProductByCode',
        'mdlCashPayment' => 'mdlCashPayment',
        'mdlAnticipoApartado' => 'mdlAnticipoApartado',
        'crearApartado' => 'crearApartado',
        'addProducto'
    ];

    public function updatedVentaT($value, $key){
        $parts = explode('.', $key);
        if(str_starts_with($key, 'registros.')){
            $this->venta_t->registros[$parts[1]]->save();
        }
        $this->venta_t->refresh();
    }

    public function updatedSearchValueProductos($propertyName)
    {
        $this->resetPage('productPage');
    }

    public function updatedSearchValueClientes($propertyName)
    {
        $this->resetPage('clientePage');
    }

    public function mount()
    {
        $this->formas_pago_restantes = new Collection();
        $this->formas_pago_venta = new Collection([array('forma' => 'EFECTIVO', 'monto' => 0)]);
        $this->formas_pago = new Collection([
            'EFECTIVO',
            'TARJETA',
            'TRANSFERENCIA'
        ]);

        $this->cargarVenta();

        $this->changeFormaPago();
        // $this->sidebarCollapse = true;
    }

    public function render(){
        $user = Auth::user();

        return view('livewire.ventas.pos.view', [
            'clientes' => Cliente::orderBy('id', 'desc')
                ->orWhere('nombre', 'LIKE', '%' . $this->searchValueClientes . '%')
                ->paginate(20, ['*'], 'clientePage'),
            'productos' => Producto::orderBy('marca')
                ->orderBy('descripcion')
                ->orWhere('descripcion', 'LIKE', '%' . $this->searchValueProductos . '%')
                ->orWhere('marca', 'LIKE', '%' . $this->searchValueProductos . '%')
                ->orWhere('codigo', 'LIKE', '%' . $this->searchValueProductos . '%')
                ->paginate(20, ['*'], 'productPage'),
            'ventasGuardadas' => VentaTemporal::where('usuario_id', $user->id)
            ->where('sucursal_id', $user->sucursal_default)
            ->where('activo', false)->count(),
        ]);
    }

    function test(){
        $this->emit('selectText', '.formaPago');
    }

    ///////////////////////////////////////////////////////////////

    public function getVentasGuardadasProperty(){
        $user = Auth::user();
        $qty = VentaTemporal::where('usuario_id', $user->id)
            ->where('sucursal_id', $user->sucursal_default)
            ->where('activo', false)->count();
        
        if($qty > 0){
            return "({$qty})";
        }
        return "";
            
    }

    public function limpiarVenta(){
        foreach ($this->venta_t->registros as $reg) {
            $reg->delete();
        }
        $this->venta_t->delete();
        $this->cargarVenta();
        $this->resetInput();
    }

    public function getSavedSalesProperty(){
        return VentaTemporal::where([
            'usuario_id' => Auth::user()->id,
            'sucursal_id' => Auth::user()->sucursal_default,
            'activo' => false
        ])->get();
    }

    public function eliminarVentaGuardada($id){
        // VentaTemporal::where('id', $id)->delete();
        // $this->emit('ok', 'Venta Guardada Eliminada');
        $venta = VentaTemporal::find($id);
        foreach ($venta->registros as $reg) {
            $reg->delete();
        }
        $venta->delete();
        $this->emit('ok', 'Venta Eliminada');

        if(!$this->ventas_guardadas){
            $this->emit('closeModal', '#mdlVentasGuardadas');
        }
    }

    public function guardarVenta($useModal = true){
        if($this->ventas_guardadas && $useModal){
            $this->emit('showModal', '#mdlVentasGuardadas');
            return;
        }

        if(collect($this->venta_t->registros)->count() < 1){
            $this->emit('info', 'No hay productos en la venta');
            return;
        }

        $this->venta_t->activo = false;
        $this->venta_t->save();
        $this->cargarVenta();

        if(!$useModal){
            $this->emit('closeModal', '#mdlVentasGuardadas');
        }
    }

    public function cargarVentaGuardada($id){
        VentaTemporal::where([
            'id' => $id,
        ])->update(['activo' => true]);

        if(collect($this->venta_t->registros)->count() < 1){
            $this->limpiarVenta();
        }
        else{
            $this->venta_t->activo = false;
            $this->venta_t->save();
            $this->cargarVenta();
        }

        $this->emit('closeModal', '#mdlVentasGuardadas');
    }

    public function aplicarDescuento(){
        $this->validate([
            'descuento' => 'required|numeric|min:0|max:50',
        ]);
        foreach ($this->venta_t->registros as $item) {
            // $item->precio = $item->precio * (1 - ($this->descuento / 100));
            $item->descuento = $this->descuento;
            $item->save();
        }
        $this->descuento = 0;
        $this->emit('closeModal', '#mdlDescuento');
        $this->emit('ok', 'Se ha aplicado descuento');
    }

    public function aplicarDescuentoRegistro(){
        $this->validate([
            'selectedRegistroTemporal.descuento' => 'required|numeric|min:0|max:50',
        ]);

        $this->selectedRegistroTemporal->save();
        $this->selectedRegistroTemporal = null;
        $this->venta_t->load('registros');
        $this->emit('closeModal', '#mdlDescuentoRegistro');
        $this->emit('ok', 'Se ha aplicado descuento');
    }

    public function resetInput(){
        $this->formas_pago_venta = new Collection([array('forma' => 'EFECTIVO', 'monto' => 0)]);
        $this->formas_pago = new Collection([
            'EFECTIVO',
            'TARJETA',
            'TRANSFERENCIA'
        ]);

        $this->changeFormaPago();
    }

    public function cargarVenta(){
        $this->venta_t = VentaTemporal::where([
            'usuario_id' => Auth::user()->id,
            'sucursal_id' => Auth::user()->sucursal_default,
            'activo' => true
        ])->first();

        if ($this->venta_t == null) {
            $this->venta_t = VentaTemporal::create([
                'usuario_id' => Auth::user()->id,
                'sucursal_id' => Auth::user()->sucursal_default,
            ]);
        }
    }

    public function sumarPuntos($monto){
        if($this->venta_t->cliente){
            $puntos = intval($monto / 20);
            $this->venta_t->cliente->sumarPuntos($puntos);
        }
    }

    public function restarPuntos(){
        $this->venta_t->cliente->sumarPuntos((-1) * ceil($this->venta_t->total()));
    }

    public function saveComment(){
        $this->venta_t->save();
    }

    public function generarVenta(){
        $venta = new Venta();
        $venta->cliente_id = $this->venta_t->cliente_id;
        $venta->tasa_iva = $this->venta_t->sucursal->tasa_iva;
        if($venta->save())
        {
            foreach ($this->venta_t->registros as $reg) {
                $vr = new VentaRegistro();
                $vr->venta_id = $venta->id;
                $vr->producto_id = $reg->producto_id;
                $vr->codigo = $reg->codigo;
                $vr->descripcion = $reg->descripcion;
                $vr->cantidad = $reg->cantidad;
                $vr->precio = $reg->precio_con_descuento;
                if($vr->save())
                {
                    $inventario = $vr->producto->inventario_actual();
                    $inventario->existencia -= $vr->cantidad;
                    if($inventario->save())
                    {
                        MovimientoInventario::create([
                            'usuario_id' => $venta->usuario_id,
                            'tipo' => 'VENTA',
                            'producto_id' => $vr->producto_id,
                            'emisor_id' => $venta->sucursal_id,
                            'cantidad' => $vr->cantidad,
                            'comentarios' => 'Venta #' . str_pad($vr->venta_id, 4, '0', STR_PAD_LEFT),
                        ]);
                    }
                }
            }

            $pagosCount = $this->formas_pago_venta->count();
            $totalPago = 0;
            foreach($this->formas_pago_venta as $ing)
            {
                $monto = $pagosCount == 1 ? $this->venta_t->PagoRequerido : $ing['monto'];
                $pago = $ing['monto'];
                // $cambio = $pagosCount == 1 ? $this->PagoRequerido - $ing['monto'] : 0;
                $cambio = floatval($pago) - floatval($monto);

                if($monto > 0){
                    $venta->push(Ingreso::create([
                        'tipo' => 'ANTICIPO',
                        'forma_pago' => $ing['forma'],
                        'monto' => $monto,
                        'referencia' => '',
                        'model_type' => Venta::class,
                        'model_id' => $venta->id,
                        'pago' => $pago,
                        'cambio' => $cambio,
                    ]));

                    $totalPago += $monto;
                }
            }

            $this->sumarPuntos($totalPago);

            $this->emit('closeModal');
            $this->emit('ok', 'Se ha generado VENTA con éxito');
            $id = $venta->id;
            $this->limpiarVenta();
            
            if($this->printEtiqueta){
                $this->emit('print', 'ticket_venta#'. $id);
            }
        }


    }

    public function setProductByCode($codigo){
        $producto = Producto::where('codigo', $codigo)->first();
        if ($producto == null)
            return $this->emit('scan-notfound');
        $this->addProducto($producto);
    }

    public function addProducto(Producto $prod){
        $this->emit('closeModal', '#mdlSelectProduct');

        $inventario = $prod->inventario_actual();

        if ($inventario == null) {
            $this->emit('info', $prod->descripcion, 'No hay existencias');
            return;
        }
        $disp = $inventario->qty_disponible();
        if ($disp < 1) {
            $this->emit('info', $prod->descripcion, 'Cantidad disponible: ' . $disp);
            return;
        }

        VentaRegistroTemporal::create([
            'venta_temporal_id' => $this->venta_t->id,
            'producto_id' => $prod->id,
            'codigo' => $prod->codigo,
            'descripcion' => $prod->descripcion,
            'cantidad' => 1,
            'precio' => $prod->inventario_actual()->precio,
        ]);
        $this->venta_t->load('registros');
    }

    public function setClient($id){
        if ($id == 0) {
            $this->venta_t->cliente_id = null;
            $this->venta_t->save();
        } else {
            $this->venta_t->cliente_id = $id;
            $this->venta_t->save();
            $this->emit('closeModal', '#mdlSelectClient');
        }
        $this->cargarVenta();
    }

    public function destroy($reg_id)
    {
        $prod = VentaRegistroTemporal::find($reg_id);
        if ($prod->delete()) {
            $this->emit('ok', 'Se ha eliminado Producto: ' . strtoupper($prod->descripcion));
        }

        $this->cargarVenta();
    }
    
    public function addQty($id_reg, $qty)
    {
        $ob = VentaRegistroTemporal::findOrFail($id_reg);
        if (($ob->cantidad + $qty) < 1) {
            return;
        }

        $disp = $ob->producto->inventario_actual()->qty_disponible();
        if ($disp < $qty) {
            $this->emit('info', $ob->descripcion, 'Cantidad disponible: ' . $disp);
        } else {
            $ob->cantidad += $qty;
            $ob->save();
            $this->cargarVenta();
        }
    }

    public function changeFormaPago()
    {
        $this->formas_pago_restantes = $this->formas_pago->diff($this->formas_pago_venta->pluck('forma'));

        $this->emit('$refresh');
    }

    public function addFormaPago()
    {
        if ($this->formas_pago_restantes->count() > 0) {
            $this->formas_pago_venta->push([
                'forma' => $this->formas_pago_restantes->first(),
                'monto' => 0,
            ]);
            $this->changeFormaPago();
        }
    }

    public function removeFormaPago($index)
    {
        $this->formas_pago_venta->splice($index, 1);
        $this->changeFormaPago();
    }

    public function selectText($target)
    {
        $this->emit('selectText', $target);
    }

    public function mdlPago(){
        $this->venta_t->PagoRequerido = $this->venta_t->total();
        if($this->venta_t->cliente){
            $this->emit('click', '#iptPagoRequerido');
        }
        else{
            $this->metodosPago();
        }
        
    }

    public function metodosPago(){
        if($this->venta_t->cliente){
            $creditoDisponible = $this->venta_t->cliente->credito_disponible();
            $pagoMinimo = $this->venta_t->pagoMinimo($creditoDisponible);
            if ($this->venta_t->PagoRequerido < $pagoMinimo){
                return;
            }
        }

        $this->resetInput();
        $this->emit('closeModal', '#mdlPagoCredito');
        $this->emit('showModal', '#mdlPago');
        $this->emit('selectText', '.formaPago');
    }

    public function pagarConPuntos(){
        if($this->venta_t->cliente->puntos < $this->venta_t->total()){
            $this->emit('error', 'Puntos Insuficientes');
            return;
        }
        $p = ceil($this->venta_t->total());
        $this->emit('confirm', "¿Desea pagar venta con {$p} PUNTOS?", 'Pagar con Puntos', 'generarVentaPuntos');
    }

    public function generarVentaPuntos(){
        $venta = new Venta();
        $venta->usuario_id = $this->venta_t->usuario_id;
        $venta->sucursal_id = $this->venta_t->sucursal_id;
        $venta->cliente_id = $this->venta_t->cliente_id;
        $venta->tasa_iva = $this->venta_t->sucursal->tasa_iva;
        if($venta->save())
        {
            foreach ($this->venta_t->registros as $reg) {
                $vr = new VentaRegistro();
                $vr->venta_id = $venta->id;
                $vr->producto_id = $reg->producto_id;
                $vr->codigo = $reg->codigo;
                $vr->descripcion = $reg->descripcion;
                $vr->cantidad = $reg->cantidad;
                $vr->precio = $reg->precio_con_descuento;
                if($vr->save())
                {
                    $inventario = $vr->producto->inventario_actual();
                    $inventario->existencia -= $vr->cantidad;
                    if($inventario->save())
                    {
                        MovimientoInventario::create([
                            'usuario_id' => $venta->usuario_id,
                            'tipo' => 'VENTA',
                            'producto_id' => $vr->producto_id,
                            'emisor_id' => $venta->sucursal_id,
                            'cantidad' => $vr->cantidad,
                            'comentarios' => 'Venta #' . str_pad($vr->venta_id, 4, '0', STR_PAD_LEFT),
                        ]);
                    }
                }
            }

            $this->restarPuntos();

            $venta->push(Ingreso::create([
                'tipo' => 'PUNTOS',
                'usuario_id' => Auth::user()->id,
                'forma_pago' => 'PUNTOS',
                'monto' => ceil($venta->total()),
                'referencia' => '',
                'model_type' => Venta::class,
                'model_id' => $venta->id,
                'pago' => ceil($venta->total()),
                'cambio' => 0,
            ]));

            $this->emit('closeModal');
            $this->emit('ok', 'Se ha generado VENTA con éxito');
            $id = $venta->id;
            $this->limpiarVenta();
            
            if($this->printEtiqueta){
                $this->emit('print', 'ticket_venta#'. $id);
            }
        }
    }

    public function mdlAnticipoApartado($dias){
        if($dias < 1 || $dias > 60){
            $this->emit('info', 'Ingrese de 1 hasta 60 días de apartado');
            return;
        }

        $this->diasApartado = $dias;
        $this->emit('initMdlAnticipoApartado', $this->venta_t, 'mdlCashPayment');
        return;
    }

    public function mdlCashPayment($cantidadAPagar){
        $this->venta_t->PagoRequerido = $cantidadAPagar;
        $this->emit('initMdlCashPayment', $cantidadAPagar, 'crearApartado');
    }

    public function crearApartado($pagos){
        
        $apartado = Apartado::create([
            'cliente_id' => $this->venta_t->cliente_id,
            'vence' => Carbon::today()->addDays($this->diasApartado),
        ]);

        if($apartado->save())
        {
            foreach ($this->venta_t->registros as $reg) {
                $vr = new ApartadoConcepto([
                    'apartado_id' => $apartado->id,
                    'producto_id' => $reg->producto_id,
                    'codigo' => $reg->codigo,
                    'descripcion' => $reg->descripcion,
                    'cantidad' => $reg->cantidad,
                    'precio' => $reg->precio,
                ]);
                $vr->save();
            }

            $pagosCount = collect($pagos)->count();
            foreach($pagos as $ing)
            {
                $monto = $pagosCount == 1 ? $this->venta_t->PagoRequerido : $ing['monto'];
                $pago = $ing['monto'];
                $cambio = floatval($pago) - floatval($monto);

                if($monto > 0){
                    Ingreso::create([
                        'tipo' => 'ANTICIPO',
                        'forma_pago' => $ing['forma'],
                        'monto' => $monto,
                        'referencia' => '',
                        'model_type' => Apartado::class,
                        'model_id' => $apartado->id,
                        'pago' => $pago,
                        'cambio' => $cambio,
                    ]);
                }
            }

            $this->emit('info', Carbon::parse($apartado->vence)->format('M/d/Y'), 'Se han apartado productos hasta:');
            $id = $apartado->id;
            $this->limpiarVenta();
            $this->emit('print', 'ticket_apartado#'. $id);
        }
    }

    public function buscarInputProduct(){
        // $this->emit('ok');
        $this->emit('initMdlSelectProducto', $this->inputProduct);
        $this->inputProduct = null;
    }

    public function mdlDescuento($idRegistroTemp){
        $this->selectedRegistroTemporal = VentaRegistroTemporal::findOrFail($idRegistroTemp);
        $this->emit('showModal', '#mdlDescuentoRegistro');
    }

}
