<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Comentario;
use App\Models\Ingreso;
use App\Models\Equipo;
use App\Models\IngresoPropietario;
use App\Models\Renta;
use App\Models\RentaRegistro;
use App\Models\RentaTemporal;
use App\Models\RentaRegistroTemporal;
use App\Models\Traslado;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Rentas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $renta_t;
    public $searchValueClientes;
    public $searchValueEquipos;
    public $searchValueTraslados;

    public Equipo $equipo;
    public RentaRegistroTemporal $registro_t;

    public Collection $formas_pago_renta;
    public Collection $formas_pago;
    public Collection $formas_pago_restantes;

    protected $rules = [
        'renta_t.comentarios' => 'string',
        'renta_t.registros.*.pagado' => 'numeric',
        'renta_t.fecha_renta' => 'date',
        'registro_t.horometro_inicio' => 'numeric',
        'registro_t.unidades' => 'numeric',
    ];

    protected $listeners = [
        'destroy' => 'destroy',
        'addQty' => 'addQty',
    ];

    public function mount(){
        $this->formas_pago_restantes = new Collection();
        $this->formas_pago_venta = new Collection([array('forma' => 'EFECTIVO', 'monto' => 0)]);
        $this->formas_pago = new Collection([
            'EFECTIVO',
            'CHEQUE',
            'TARJETA DEBITO',
            'TARJETA CREDITO',
            'TRANSFERENCIA'
        ]);

        $this->equipo = new Equipo();

        $this->cargarRenta();

        $this->changeFormaPago();
    }

    public function render(){
        return view('livewire.rentas.crear_renta.view', [
            'clientes' => Cliente::orderBy('id', 'desc')
                ->orWhere('nombre', 'LIKE', '%' . $this->searchValueClientes . '%')
                ->paginate(20),
            'equipos' => Equipo::orderBy('descripcion', 'asc')
                ->orWhere('descripcion', 'LIKE', '%' . $this->searchValueEquipos . '%')
                ->paginate(20),
            'traslados' => Traslado::orderBy('destino', 'asc')
                ->orWhere('destino', 'LIKE', '%' . $this->searchValueTraslados . '%')
                ->get(),
        ]);
    }

    ///////////////////////////////////////////////////////////////

    public function limpiarRenta(){
        foreach ($this->renta_t->registros as $reg) {
            $reg->delete();
        }
        $this->renta_t->delete();
        $this->cargarRenta();
        $this->resetInput();
    }

    public function resetInput(){
        $this->formas_pago_renta = new Collection([array('forma' => 'EFECTIVO', 'monto' => 0)]);
        $this->changeFormaPago();
    }

    public function cargarRenta(){
        $this->renta_t = RentaTemporal::where(['usuario_id' => Auth::user()->id, 'sucursal_id' => Auth::user()->sucursal_default])->first();
        if ($this->renta_t == null) {
            $this->renta_t = RentaTemporal::create([
                'usuario_id' => Auth::user()->id,
                'sucursal_id' => Auth::user()->sucursal_default,
                'fecha_renta' => Carbon::today(),
            ]);
        }
    }

    public function saveComment(){
        $this->renta_t->save();
    }

    public function validacion(){        
        $this->emit('ok', 'Test', 'Seleccione cliente');
        return false;
    }

    public function generarRenta(){
        // $this->emit('alert', $this->renta_t->fecha_renta);
        // $this->emit('alert', date('Y-m-d h:i A'));
        if($this->renta_t->fecha_renta < date('Y-m-d')){
            $this->emit('warning', 'Fecha de renta inválida', 'Fecha de Renta');
            return;
        }

        $renta = new Renta();
        $renta->fecha = date('Y-m-d H:i:s');
        if($this->renta_t->fecha_renta > date('Y-m-d')){
            $renta->fecha = Carbon::parse($this->renta_t->fecha_renta)->addHour(12);
        }
        
        $renta->usuario_id = $this->renta_t->usuario_id;
        $renta->sucursal_id = $this->renta_t->sucursal_id;
        $renta->cliente_id = $this->renta_t->cliente_id;
        // $renta->comentarios = $this->renta_t->comentarios;
        if($renta->save())
        {
            if($this->renta_t->comentarios){
                Comentario::create([
                    'tipo' => 'CREACION',
                    'mensaje' => $this->renta_t->comentarios,
                    'usuario_id' => Auth::user()->id,
                    'model_id' => $renta->id,
                    'model_type' => Renta::class,
                ]);
            }

            foreach ($this->renta_t->registros as $reg) {
                $vr = new RentaRegistro();
                $vr->renta_id = $renta->id;
                $vr->model_type = $reg->model_type;
                $vr->model_id = $reg->model_id;
                $vr->propietario = 'N/A';

                if($reg->model_type == Traslado::class){

                    $vr->fua = "N/A";
                    $vr->descripcion = "TRASLADO: " . $reg->model->destino;
                    $vr->horometro_inicio = 0;

                } else if($reg->model_type == Equipo::class){

                    $vr->fua = $reg->model->fua;
                    $vr->descripcion = $reg->model->descripcion;
                    $vr->horometro_inicio = $reg->horometro_inicio;
                    $vr->propietario = $reg->model->propietario;
                    $vr->fecha_retorno = $reg->retorno();

                }

                $vr->unidades = $reg->unidades;
                $vr->tipo_renta = $reg->tipo_renta;
                $vr->cantidad = $reg->cantidad;
                $vr->precio = $reg->precio;
                $vr->pagado = $reg->pagado;
                // $vr->retorno = $reg->retorno(); ALEKSO
                $vr->recibido = $reg->model_type == Traslado::class;
                
                if($vr->save())
                {

                }
            }

            $pago = $this->renta_t->registros->sum('pagado');
            if($pago > 0){
                
                $ingreso = Ingreso::create([
                    'tipo' => 'ANTICIPO',
                    'usuario_id' => Auth::user()->id,
                    'forma_pago' => "TEST",
                    'monto' => $pago,
                    'referencia' => '***',
                    'model_type' => Renta::class,
                    'model_id' => $renta->id,
                    'pago' => $pago,
                    'cambio' => 0,
                ]);

                $renta->push($ingreso);

                foreach ($renta->registros as $elem) {
                    if($elem->pagado > 0){
                        $elem->push(IngresoPropietario::create([
                            'usuario_id' => Auth::user()->id,
                            'ingreso_id' => $ingreso->id,
                            'model_id' => $elem->id,
                            'model_type' => get_class($elem),
                            'monto' => $elem->pagado,
                            'propietario' => $elem->propietario,
                        ]));
                    }
                }
            }
            $this->emit('closeModal', '#mdlPago');

            $this->emit('ok', 'Se ha generado RENTA con éxito');
            $this->emit('print', 'ticket_renta/'. $renta->id);
            $this->emit('redirect', 'pdf/contrato_renta/'. $renta->id);
            $this->limpiarRenta();
        }


    }

    public function setProductByCode($codigo){
        $producto = Equipo::where('codigo', $codigo)->first();
        if ($producto == null)
            return $this->emit('scan-notfound');        
        $this->setProduct($producto);
    }

    public function mdlSelectEquipment(){
        $this->emit('showModal', '#mdlSelectEquipment');
    }

    public function mdlEntidadesFiscales(){
        $this->emit('showModal', '#mdlEntidadesFiscales');
    }

    public function mdlSelectRoute(){
        $this->emit('showModal', '#mdlSelectRoute');
    }

    public function mdlPrecioRentas(Equipo $equipo, $id_reg = 0){
        $this->equipo = $equipo;
        if($id_reg == 0){
            $this->registro_t = new RentaRegistroTemporal();
        }else{
            $this->registro_t = RentaRegistroTemporal::findOrFail($id_reg);
        }
        $this->emit('closeModal', '#mdlSelectEquipment');
        $this->emit('showModal', '#mdlRentaPrecios');
    }

    public function agregarEquipo($tipo){

        switch ($tipo) {
            case 'HORA':
                $precio = $this->equipo->renta_hora;
                break;

            case 'DIA':
                $precio = $this->equipo->renta_dia;
                break;
                    
            case 'SEMANA':
                $precio = $this->equipo->renta_semana;
                break;

            case 'MES':
                $precio = $this->equipo->renta_mes;
                break;
        }

        $this->registro_t->renta_temporal_id = $this->renta_t->id;
        $this->registro_t->model_type = Equipo::class;
        $this->registro_t->model_id = $this->equipo->id;
        $this->registro_t->unidades = 1;
        $this->registro_t->tipo_renta = $tipo;
        $this->registro_t->cantidad = 1;
        $this->registro_t->precio = $precio;
        $this->registro_t->pagado = $this->registro_t->importe();
        $this->registro_t->horometro_inicio = $this->equipo->horometro;
        $this->registro_t->save();
        
        $id = $this->registro_t->id;

        $this->registro_t = new RentaRegistroTemporal();
        $this->cargarRenta();
        $this->emit('closeModal', '#mdlRentaPrecios');

        if($this->equipo->horometro){
            $this->mdlHorometro($id);
        }
    }

    public function mdlUnidades($id){
        $this->registro_t = RentaRegistroTemporal::find($id);
        $this->emit('showModal', '#mdlUnidades');
    }

    public function setUnidades(){
        if($this->registro_t->unidades <= 0){
            $this->emit('info', 'Ingrese un valor válido');
            return;
        }
        $registro = RentaRegistroTemporal::findOrFail($this->registro_t->id);
        $cantidadDisponible = $this->registro_t->model->disponible();
        $cantidadDisponible += $registro->unidades;
        if($cantidadDisponible >= $this->registro_t->unidades)
        {
            $this->registro_t->save();
            $this->renta_t->load('equipos');
            $this->emit('closeModal', '#mdlUnidades');
        } else {
            $max = $cantidadDisponible . " Unidad" . ($cantidadDisponible > 1 ? "es" : "");
            $this->emit('info', 'Maximo '. $max);
        }
    }

    public function mdlHorometro($id){
        $this->registro_t = RentaRegistroTemporal::find($id);
        $this->emit('showModal', '#mdlHorometro');
    }

    public function setHorometro(){
        $init = $this->registro_t->model->horometro;
        if($this->registro_t->horometro_inicio >= $init){
            if($this->registro_t->save()){
                $this->emit('closeModal', '#mdlHorometro');                
            }
        } else {
            $this->emit('info', "Horómetro inicial: $init", 'Horómetro Inválido');
        }
    }

    public function agregarTraslado(Traslado $traslado, $viaje){
        $this->registro_t = new RentaRegistroTemporal();
        $this->registro_t->renta_temporal_id = $this->renta_t->id;
        $this->registro_t->model_type = Traslado::class;
        $this->registro_t->model_id = $traslado->id;
        $this->registro_t->unidades = 1;
        $this->registro_t->tipo_renta = $viaje;
        $this->registro_t->cantidad = 1;
        $this->registro_t->precio = $traslado[Str::lower($viaje)];
        $this->registro_t->pagado = $this->registro_t->importe();
        $this->registro_t->save();
        
        $this->registro_t = new RentaRegistroTemporal();
        $this->cargarRenta();
        $this->emit('closeModal', '#mdlSelectRoute');
    }

    public function saveRegistro($indx){
        $this->renta_t->registros[$indx]->save();
    }

    public function setClient($id){
        if ($id == 0) {
            $this->renta_t->cliente_id = null;
            $this->renta_t->entidad_fiscal_id = null;
            $this->renta_t->save();
        } else {
            $this->renta_t->cliente_id = $id;
            $this->renta_t->entidad_fiscal_id = null;
            $this->renta_t->save();

            $this->renta_t->load('cliente');

            if($this->renta_t->cliente->entidades_fiscales->count() == 1){
                $this->setEntidadFiscal($this->renta_t->cliente->entidades_fiscales[0]->id);
            }

            $this->emit('closeModal', '#mdlSelectClient');
        }
        $this->cargarRenta();
    }

    public function setEntidadFiscal($id){
        if ($id == 0) {
            $this->renta_t->entidad_fiscal_id = null;
            $this->renta_t->save();
        } else {
            $this->renta_t->entidad_fiscal_id = $id;
            $this->renta_t->save();
            $this->emit('closeModal', '#mdlEntidadesFiscales');
        }
        $this->cargarRenta();
    }

    public function destroy($reg_id){
        $prod = RentaRegistroTemporal::find($reg_id);
        if ($prod->delete()) {
            $this->emit('ok', 'Se ha eliminado registro');
        }

        $this->cargarRenta();
    }

    public function addQty($id_reg, $qty){
        $ob = RentaRegistroTemporal::findOrFail($id_reg);
        if (($ob->cantidad + $qty) < 1) {
            return;
        }

        $ob->cantidad += $qty;
        $ob->save();
        $this->cargarRenta();
    }

    public function changeFormaPago(){
        $this->formas_pago_restantes = $this->formas_pago->diff($this->formas_pago_venta->pluck('forma'));
        $this->emit('$refresh');
    }

    public function addFormaPago(){
        if ($this->formas_pago_restantes->count() > 0) {
            $this->formas_pago_renta->push([
                'forma' => $this->formas_pago_restantes->first(),
                'monto' => 0,
            ]);
            $this->changeFormaPago();
        }
    }

    public function removeFormaPago($index){
        // array_splice($this->formas_pago_renta, $index, 1);
        //$this->formas_pago_renta->splice($index, 1);
        $this->changeFormaPago();
        //$this->emit('alert', $index);
    }

    public function selectText($target){
        $this->emit('selectText', $target);
    }

    public function metodosPago(){
        $this->resetInput();
        $this->emit('closeModal', '#mdlPagoCredito');
        $this->emit('showModal', '#mdlPago');
    }
}
