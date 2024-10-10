<?php

namespace App\Http\Livewire\Facturas;

use App\Models\ClaveProducto;
use App\Models\ClaveUnidad;
use App\Models\Cliente;
use App\Models\FacturaTemporal;
use App\Models\FacturaTemporalConcepto;
use App\Models\Renta;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Classes\FacturacionConstants;
use App\Http\Controllers\FacturaController;
use App\Models\Producto;
use App\Models\VentaRegistro;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class CrearFactura extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $formas_pago = FacturacionConstants::FORMAS_PAGO;
    protected $metodos_pago = FacturacionConstants::METODOS_PAGO;
    protected $uso_cfdi = FacturacionConstants::USO_CFDI;

    public $searchValueClientes;
    public $searchValueVentas;
    public $searchValueRentas;
    public $searchValueClaveProductos;
    public $searchValueClaveUnidades;
    public $searchValueProductos;
    public $searchValueEquipos;
    public $searchValueTraslados;
    public $claveCreateMode = false;
    
    public $descripcionConcepto;

    public $loading = false;

    public $factura_t;
    public FacturaTemporalConcepto $concepto_t;

    //To create new products/unit keys
    public ClaveProducto $claveProducto;
    public ClaveUnidad $claveUnidad;

    public $periocidad;
    public $meses;
    public $anio;

    protected $listeners = [
        'generarFactura',
        'timbradoSuccess',
        'setCliente',
        'setProducto',
        'setVentas',
    ];

    protected $rules = [
        'factura_t.model_id' => 'numeric|nullable',
        'factura_t.forma_pago' => 'string|required',
        'factura_t.metodo_pago' => 'string|required',
        'factura_t.uso_cfdi' => 'string|required',
        'factura_t.desglosar_iva' => 'boolean|required',

        'factura_t.conceptos.*.descripcion' => 'string',
        'factura_t.conceptos.*.cantidad' => 'numeric',
        'factura_t.conceptos.*.valor_unitario' => 'numeric',

        'concepto_t.clave_prod_serv' => 'string',
        'concepto_t.clave_unidad' => 'string',

        'claveProducto.clave' => 'string|unique:clave_productos,clave|max:30',
        'claveProducto.nombre' => 'string|max:255',
        'claveUnidad.clave' => 'string|unique:clave_unidades,clave|max:30',
        'claveUnidad.nombre' => 'string|max:255',
        'descriptionConcepto' => 'string',
    ];

    public function mount(){
        $this->cargarFactura();
        $this->claveProducto = new ClaveProducto();
        $this->claveUnidad = new ClaveUnidad();

        $this->loadPublicInvoiceData();
    }

    public function loadPublicInvoiceData(){
        try{
            $data = json_decode($this->factura_t->comentarios);
            $this->periocidad = $data->periocidad;
            $this->meses = $data->meses;
            $this->anio = $data->anio;
        }
        catch(\Exception $e){
            $this->periocidad = null;
            $this->meses = null;
            $this->anio = null;
        }
    }

    public function render()
    {
        return view('livewire.facturas.crear_factura.view', [ 
            'clientes' => Cliente::orderBy('id', 'desc')
                ->orWhere('nombre', 'LIKE', '%' . $this->searchValueClientes . '%')
                ->paginate(50),
            'ventas' => Venta::orderBy('id', 'desc')
                ->orWhere('id', 'like', $this->searchValueVentas.'%')
                ->orWhereHas('cliente', function($q){
                    $q->where('nombre', 'like', '%'.$this->searchValueVentas.'%');
                })
                ->paginate(50),
            'clave_productos' => ClaveProducto::orderBy('id', 'desc')
                ->orWhere('clave', 'like', '%'.$this->searchValueClaveProductos.'%')
                ->orWhere('nombre', 'like', '%'.$this->searchValueClaveProductos.'%')
                ->paginate(25),
            'clave_unidades' => ClaveUnidad::orderBy('id', 'desc')
                ->orWhere('clave', 'like', '%'.$this->searchValueClaveProductos.'%')
                ->orWhere('nombre', 'like', '%'.$this->searchValueClaveProductos.'%')
                ->paginate(25),
            'productos' => Producto::orderBy('id', 'desc')
                ->orWhere('codigo', 'like', '%'.$this->searchValueProductos.'%')
                ->orWhere('descripcion', 'like', '%'.$this->searchValueProductos.'%')
                ->paginate(25),
        ]);
    }

    public function cargarFactura(){
        $this->concepto_t = new FacturaTemporalConcepto();
        $user = Auth::user();
        $this->factura_t = FacturaTemporal::where(['usuario_id' => $user->id, 'sucursal_id' => $user->sucursal_default])->first();
        if ($this->factura_t == null) {
            $this->factura_t = FacturaTemporal::create([
                'usuario_id' => Auth::user()->id,
                'sucursal_id' => Auth::user()->sucursal_default,
                'tasa_iva' => $user->sucursal->tasa_iva,
            ]);
        }
    }

    public function confirm(){
        $rules = [
            'factura_t.forma_pago' => 'string|required',
            'factura_t.metodo_pago' => 'string|required',
            'factura_t.uso_cfdi' => 'string|required',
        ];

        if($this->factura_t->entidad_fiscal->rfc == 'XAXX010101000'){
            $rules['periocidad'] = 'string|required';
            $rules['meses'] = 'string|required';
            $rules['anio'] = 'string|required';

            $this->factura_t->comentarios = json_encode([
                'periocidad' => $this->periocidad,
                'meses' => $this->meses,
                'anio' => $this->anio,
            ]);
            $this->factura_t->save();
        }

        $this->validate($rules);

        if($this->factura_t->cliente_id == null){
            $this->emit('info', 'No se ha seleccionado cliente', 'Cliente');
            return;
        }

        if($this->factura_t->entidad_fiscal_id == null){
            $this->emit('info', 'No se ha seleccionado entidad fiscal', 'Entidad Fiscal');
            return;
        }

        // $this->emit('confirm', '¿Desea continuar?', "Generar factura por: {$this->factura_t->total_format}", 'generarFactura');
        $this->emit('showModal', '#mdlConfirmation');
    }

    public function generarFactura(){
        $factura = FacturaController::GenerarFacturaV2($this->factura_t);
        if(isset($factura['factura_id'])){
            $factura_id = $factura['factura_id'];
            $this->emit('closeModal', "#mdlConfirmation");
            $this->emit('ok', "<a target='_blank' href='/facturacion/ver_pdf/{$factura_id}'>Ver PDF de Factura</a>", null, );
            $this->limpiar();
        }
        else{
            $this->emit('error', $factura['message'], 'Error al generar factura');
        }
    }

    public function saveFactura(){
        $this->factura_t->save();
    }

    public function desglosarIvaToggle(){
        $this->saveFactura();
        // $this->factura_t->load('conceptos');
        $this->factura_t->refresh();
    }

    public function saveConcepto($indx){
        $this->factura_t->conceptos[$indx]->save();
        $this->factura_t->refresh();
    }

    public function removeConcepto($indx){
        $this->factura_t->conceptos[$indx]->delete();
        $this->factura_t->load('conceptos');
        $this->factura_t->refresh();
    }

    public function timbradoSuccess(){
        $this->limpiar();   
    }

    public function limpiar(){
        foreach ($this->factura_t->conceptos as $reg) {
            $reg->delete();
        }
        $this->factura_t->delete();
        $this->cargarFactura();
        $this->periocidad = null;
        $this->meses = null;
        $this->anio = null;
    }

    public function agregarConcepto(){
        if (Str::length($this->descripcionConcepto) < 5) {
            $this->emit('info','Mínimo 5 characteres', 'Concepto');
            return;
        }
        $concepto = new FacturaTemporalConcepto();
        $concepto->factura_temporal_id = $this->factura_t->id;
        $concepto->no_identificacion = "N/A";
        $concepto->descripcion = $this->descripcionConcepto;
        $concepto->clave_prod_serv = '01010101';
        $concepto->clave_unidad = 'H87';
        $concepto->cantidad = 1;
        $concepto->valor_unitario = 1;
        $concepto->objeto_imp = '02';
        $concepto->save();

        $this->factura_t->load('conceptos');
        $this->factura_t->refresh();

        $this->descripcionConcepto = '';
        $this->emit('closeModal', '#mdlConcepto');
    }

    public function setCliente($id){
        if ($id == 0) {
            $this->factura_t->cliente_id = null;
            $this->factura_t->entidad_fiscal_id = null;
            $this->factura_t->save();
            $this->resetValidation();
        } else {
            $this->factura_t->cliente_id = $id;
            $this->factura_t->entidad_fiscal_id = null;
            $this->factura_t->save();

            $this->factura_t->load('cliente');
            if($this->factura_t->cliente->entidades_fiscales->count() == 1){
                $this->setEntidadFiscal($this->factura_t->cliente->entidades_fiscales[0]->id);
            }

            $this->emit('closeModal', '#mdlSelectClient');
        }
        $this->cargarFactura();
    }

    public function setEntidadFiscal($id){
        if ($id == 0) {
            $this->factura_t->entidad_fiscal_id = null;
            $this->factura_t->save();
        } else {
            $this->factura_t->entidad_fiscal_id = $id;
            $this->factura_t->save();
            $this->emit('closeModal', '#mdlEntidadesFiscales');
        }
        $this->factura_t->load('entidad_fiscal');
        //$this->cargarFactura();
    }

    public function removeModel(){
        $this->resetValidation();

        foreach ($this->factura_t->conceptos as $elem) {
            $elem->delete();
        }

        $this->factura_t->model_id = null;
        $this->factura_t->model_type = null;
        $this->factura_t->cliente_id = null;
        $this->factura_t->save();
        //$this->factura_t->load('model');
        $this->cargarFactura();
    }

    public function setRenta($id){

        foreach ($this->factura_t->conceptos as $elem) {
            $elem->delete();
        }

        $renta = Renta::findOrFail($id);
        $this->factura_t->model_id = $renta->id;
        $this->factura_t->model_type = Renta::class;

        $this->setCliente($renta->cliente_id);

        foreach ($this->factura_t->model->registros as $elem) {
            $concepto = new FacturaTemporalConcepto();
            $concepto->factura_temporal_id = $this->factura_t->id;
            $concepto->no_identificacion = $elem->fua;
            $concepto->descripcion = $elem->descripcion;
            $concepto->clave_prod_serv = $elem->model->clave_producto->clave ?? '01010101';
            $concepto->clave_unidad = $elem->model->clave_unidad->clave ?? 'H87';
            $concepto->cantidad = $elem->cantidad;
            $concepto->valor_unitario = $elem->precio;
            $concepto->objeto_imp = '02';
            $concepto->save();
            // $concepto->importe = $elem->importe();
        }

        // $this->factura_t->load('model');
        // $this->factura_t->load('cliente');
        // $this->factura_t->load('conceptos');
        $this->emit('closeModal', '#mdlSelectRenta');
    }

    public function setVenta($id){
        foreach ($this->factura_t->conceptos as $elem) {
            $elem->delete();
        }

        $venta = Venta::findOrFail($id);
        $this->factura_t->model_id = $venta->id;
        $this->factura_t->model_type = Venta::class;

        $this->setCliente($venta->cliente_id);

        foreach ($this->factura_t->model->registros as $elem) {
            $concepto = new FacturaTemporalConcepto();
            $concepto->factura_temporal_id = $this->factura_t->id;
            $concepto->no_identificacion = $elem->codigo;
            $concepto->descripcion = $elem->descripcion;
            $concepto->clave_prod_serv = $elem->producto->clave_producto->clave ?? '01010101';
            $concepto->clave_unidad = $elem->producto->clave_unidad->clave ?? 'H87';
            $concepto->cantidad = $elem->cantidad;
            $concepto->valor_unitario = $elem->precio;
            $concepto->objeto_imp = '02';
            $concepto->save();
            // $concepto->importe = $elem->importe();
        }
        
        //$this->factura_t->load('cliente');
        //$this->factura_t->load('entidad_fiscal');
        //$this->factura_t->load('conceptos');
        $this->emit('closeModal', '#mdlSelectVenta');
    }

    public function mdlEntidadesFiscales(){
        $this->emit('showModal', '#mdlEntidadesFiscales');
    }

    public function mdlClaveProductos($id){
        $this->concepto_t = FacturaTemporalConcepto::find($id);
        $this->emit('showModal', '#mdlSelectClaveProducto');
    }

    public function setClaveProducto($clave){
        $this->concepto_t->clave_prod_serv = $clave;
        $this->concepto_t->save();
        $this->factura_t->load('conceptos');
        $this->emit('closeModal', '#mdlSelectClaveProducto');
    }

    public function mdlClaveUnidades($id){
        $this->concepto_t = FacturaTemporalConcepto::find($id);
        $this->emit('showModal', '#mdlSelectClaveUnidad');
    }

    public function setClaveUnidad($clave){
        $this->concepto_t->clave_unidad = $clave;
        $this->concepto_t->save();
        $this->factura_t->load('conceptos');
        $this->emit('closeModal', '#mdlSelectClaveUnidad');
    }

    public function createClaveProducto(){
        $this->validate([
            'claveProducto.clave' => 'string|unique:clave_productos,clave|max:30',
            'claveProducto.nombre' => 'string|max:255',
        ]);

        $this->claveProducto->clave = Str::upper($this->claveProducto->clave);

        if($this->claveProducto->save()){
            $this->emit('ok', 'Se ha registrado clave');
            $this->claveCreateMode = false;
            $this->claveProducto = new ClaveProducto();
        }
    }

    public function createClaveUnidad(){
        $this->validate([
            'claveUnidad.clave' => 'string|unique:clave_unidades,clave|max:30',
            'claveUnidad.nombre' => 'string|max:255',
        ]);
        
        $this->claveUnidad->clave = Str::upper($this->claveUnidad->clave);

        if($this->claveUnidad->save()){
            $this->emit('ok', 'Se ha registrado clave');
            $this->claveCreateMode = false;
            $this->claveUnidad = new ClaveUnidad();
        }
    }

    

    public function ver(){
        // $this->emit('alert', $this->model);
    }

    public function setProducto($id){
        $producto = Producto::findOrFail($id);

        $concepto = new FacturaTemporalConcepto();
        $concepto->factura_temporal_id = $this->factura_t->id;
        $concepto->no_identificacion = $producto->codigo;
        $concepto->descripcion = $producto->descripcion;
        $concepto->clave_prod_serv = $producto->clave_producto->clave ?? '01010101';
        $concepto->clave_unidad = $producto->clave_unidad->clave ?? 'H87';
        $concepto->cantidad = 1;
        $concepto->valor_unitario = $producto->current_inventory->precio ?? 0;
        $concepto->objeto_imp = '02';
        $concepto->save();

        $this->factura_t->load('conceptos');
        $this->factura_t->refresh();
    }

    public function setVentas($ids){
        $ids = array_keys($ids);

        $registros = VentaRegistro::select(DB::raw('
            venta_registros.codigo,
            clave_productos.clave as claveProducto,
            productos.descripcion as descripcion,
            clave_unidades.clave as claveUnidad,
            SUM(cantidad) as sumCantidad,
            SUM(cantidad * precio) as sumImporte'   
        ))
        ->join('productos', 'venta_registros.producto_id', '=', 'productos.id')
        ->join('clave_productos', 'productos.clave_producto_id', '=', 'clave_productos.id')
        ->join('clave_unidades', 'productos.clave_unidad_id', '=', 'clave_unidades.id')
        ->whereIn('venta_id', $ids)
        ->groupBy('clave_productos.id')
        ->get();
        
        foreach ($registros as $elem) {
            $concepto = new FacturaTemporalConcepto();
            $concepto->factura_temporal_id = $this->factura_t->id;
            $concepto->no_identificacion = $elem->codigo ?? "N/A";
            $concepto->descripcion = $elem->descripcion;
            $concepto->clave_prod_serv = $elem->claveProducto ?? '01010101';
            $concepto->clave_unidad = $elem->claveUnidad ?? 'H87';
            $concepto->cantidad = $elem->sumCantidad;
            $concepto->valor_unitario = $elem->sumImporte / $concepto->cantidad;
            $concepto->objeto_imp = '02';
            $concepto->save();
        }

        $this->factura_t->load('conceptos');
        $this->factura_t->refresh();
    }

    public function setVentas2($ids){
        $ids = array_keys($ids);
        $registros = VentaRegistro::whereIn('venta_id', $ids)->get();
        
        foreach ($registros as $elem) {
            $concepto = new FacturaTemporalConcepto();
            $concepto->factura_temporal_id = $this->factura_t->id;
            $concepto->no_identificacion = $elem->codigo ?? "N/A";
            $concepto->descripcion = $elem->descripcion;
            $concepto->clave_prod_serv = $elem->producto?->clave_producto->clave ?? '01010101';
            $concepto->clave_unidad = $elem->producto?->clave_unidad->clave ?? 'H87';
            $concepto->cantidad = $elem->cantidad;
            $concepto->valor_unitario = $elem->precio;
            $concepto->objeto_imp = '02';
            $concepto->save();
        }

        $this->factura_t->load('conceptos');
        $this->factura_t->refresh();
    }
}
