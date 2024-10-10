<?php

namespace App\Http\Livewire\Cotizacion;

use App\Http\Controllers\CotizacionController;
use App\Http\Traits\EmailValidateTrait;
use App\Models\Cotizacion;
use App\Models\CotizacionRegistro;
use App\Models\CotizacionRegistroTemporal;
use App\Models\CotizacionTemporal;
use App\Models\Producto;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CrearCotizacion extends Component
{
    use EmailValidateTrait;

    public $cotizacion_t;
    public $selectedConcepto;
    public $sendEmail = false;
    public $inputEmails;
    public $inputMessage;

    protected $listeners = [
        'setProveedor' => 'setProveedor',
        'addProducto' => 'addProducto',
        'changeQty' => 'changeQty',
        'destroy',
        'limpiarCotizacion',
    ];

    protected $rules = [
        'cotizacion_t.conceptos.*.precio' => 'numeric|required',
        'cotizacion_t.comentarios' => 'string|nullable|max:255',
        'cotizacion_t.tasa_iva' => 'numeric|min:0|max:16',
    ];

    public function updated($name, $value){
        if(str_starts_with($name,'cotizacion_t.comentarios')){
            $this->cotizacion_t->save();
        }
        if(str_starts_with($name,'cotizacion_t.tasa_iva')){
            $this->cotizacion_t->save();
        }
    }

    public function priceChange($index){
        $this->cotizacion_t->conceptos[$index]->save();
    }

    public function mount(){
        $this->cargarCotizacion();
    }

    public function render(){
        return view('livewire.cotizacion.crear-cotizacion.view');
    }

    public function cargarCotizacion(){
        $this->cotizacion_t = CotizacionTemporal::where(['usuario_id' => Auth::user()->id, 'sucursal_id' => Auth::user()->sucursal_default])->first();
        if ($this->cotizacion_t == null) {
            $this->cotizacion_t = CotizacionTemporal::create([
                'usuario_id' => Auth::user()->id,
                'sucursal_id' => Auth::user()->sucursal_default,
            ]);
        }
    }

    public function limpiarCotizacion(){
        foreach ($this->cotizacion_t->conceptos as $concepto) {
            $concepto->delete();
        }
        $this->cotizacion_t->delete();
        $this->cargarCotizacion();
    }

    public function setCliente($id){
        if ($id == 0) {
            $this->cotizacion_t->cliente_id = null;
            $this->cotizacion_t->save();
        } else {
            $this->cotizacion_t->cliente_id = $id;
            $this->cotizacion_t->save();
        }
        $this->cotizacion_t->refresh();
    }

    public function addProducto(Producto $producto){
        CotizacionRegistroTemporal::create([
            'cotizacion_temporal_id' => $this->cotizacion_t->id,
            'producto_id' => $producto->id,
            'codigo' => $producto->codigo,
            'descripcion' => $producto->descripcion,
            'cantidad' => 1,
            'precio' => $producto->current_stock->precio ?? 0,
        ]);
        $this->cotizacion_t->load('conceptos');
    }

    public function mdlChangeQty($id){
        $this->selectedConcepto = CotizacionRegistroTemporal::findOrFail($id);
        $this->emit('initMdlSelectQty', $this->selectedConcepto->cantidad);
    }

    public function changeQty($qty){
        if (($this->selectedConcepto->cantidad + $qty) < 1) {
            return;
        }
        $this->selectedConcepto->cantidad = $qty;
        $this->selectedConcepto->save();
        $this->cotizacion_t->load('conceptos');
    }

    public function addQty($id_reg, $qty){
        $ob = CotizacionRegistroTemporal::findOrFail($id_reg);
        if (($ob->cantidad + $qty) < 1) {
            return;
        }
        $ob->cantidad += $qty;
        $ob->save();
        $this->cotizacion_t->load('conceptos');
    }

    public function saveComment(){
        $this->cotizacion_t->save();
    }

    public function mdlEnviarCotizacion(){
        $cliente_nombre = $this->cotizacion_t->cliente->nombre ?? "PUBLIC EN GENERAL";
        $this->inputEmails = $this->cotizacion_t->cliente->correo ?? "";
        $this->inputMessage = "Se ha generado cotización para: " . $cliente_nombre;
        $this->inputMessage .= "\n";
        $this->inputMessage .= "\n";
        $this->inputMessage .= "Saludos muchas gracias";
        return $this->emit('showModal', '#mdlEnviarCotizacion');
    }

    public function crearCotizacion(){

        if($this->sendEmail){
            $emailsArr = explode(",", $this->inputEmails);
            $emailsArr = array_filter($emailsArr, function($item){ 
                return $item;
            });
            $emailsArr = array_map(function($item){
                return trim($item);
            }, $emailsArr);
            foreach ($emailsArr as $mail) {
                if (!$this->is_valid_email($mail)) {
                    $this->emit('error', "Correo no válido: {$mail}");
                    return;
                }
            }
        }

        $cotizacion = Cotizacion::create([
            'cliente_id' => $this->cotizacion_t->cliente_id ?? null,
            'tasa_iva' => $this->cotizacion_t->tasa_iva,
            'estatus'=> $this->sendEmail ? 'ENVIADO' : 'CREADO',
            'comentarios' => $this->cotizacion_t->comentarios,
        ]);

        if($cotizacion->save()){
            foreach ($this->cotizacion_t->conceptos as $item) {
                CotizacionRegistro::create([
                    'cotizacion_id' => $cotizacion->id,
                    'producto_id' => $item->producto_id,
                    'codigo' => $item->codigo,
                    'descripcion' => $item->descripcion,
                    'cantidad' => $item->cantidad,
                    'cantidad_recibida' => 0,
                    'precio' => $item->precio,
                ]);
            }
        }

        if($this->sendEmail){
            try{
                CotizacionController::enviarCorreo($cotizacion, $this->inputMessage, $emailsArr);
                $this->emit('ok', 'Se ha enviado cotizacion por correo');
            }
            catch(Exception $e){
                $error = $e->getMessage();
                preg_match("/\[(.*?)\]/", $error, $match);
                $this->emit('error', "Correo incorrecto: {$match[1]}", "No se pudo enviar correo");
                $this->emit('console', $e);
            }
        }else{
            $this->emit('ok', 'Se ha creado cotizacion');
        }
        $this->emit('closeModal', '#mdlEnviarCotizacion');
        $this->emit('limpiarCotizacion');
    }

    public function destroy($id)
    {
        $ob = CotizacionRegistroTemporal::find($id);
        if ($ob->delete()) {
            $this->emit('ok', 'Se ha eliminado Producto: ' . strtoupper($ob->descripcion));
        }
        $this->cotizacion_t->load('conceptos');
    }
}
