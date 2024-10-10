<?php

namespace App\Http\Livewire;

use App\Models\ClaveProducto;
use App\Models\ClaveUnidad;
use App\Models\Equipo;
use App\Models\Familia;
use Livewire\Component;

class Equipos extends Component
{
    public $searchValueEquipos;
    public $equipo;

    protected $rules = [
        'equipo.fua' => 'string',
        'equipo.familia_id' => 'integer|min:1',
        'equipo.modelo' => 'string',
        'equipo.serie' => 'string',
        'equipo.year' => 'numeric',
        'equipo.cantidad' => 'integer',
        'equipo.descripcion' => 'string',
        'equipo.origen' => 'string',
        'equipo.factura' => 'string',
        'equipo.pedimento' => 'string',
        'equipo.fecha_adquisicion' => 'string',
        'equipo.horometro' => 'integer',
        'equipo.placas' => 'string',
        'equipo.moneda' => 'string',
        'equipo.cotizacion_usd' => 'numeric',
        'equipo.valor_compra' => 'numeric',
        'equipo.valor_traslado' => 'numeric',
        'equipo.valor_importacion' => 'numeric',
        'equipo.renta_hora' => 'numeric',
        'equipo.renta_dia' => 'numeric',
        'equipo.renta_semana' => 'numeric',
        'equipo.renta_mes' => 'numeric',
        'equipo.comentarios' => 'string',
        'equipo.propietario' => 'string',
        'equipo.activo' => 'boolean',
        'equipo.clave_producto_id' => 'integer|required',
        'equipo.clave_unidad_id' => 'integer|required',
    ];

    public function mount(){
        //$this->equipo = new Equipo();
    }

    public function render(){
        if(isset($this->equipo)){
            return view('livewire.equipos.edit',[
                'familias' => Familia::all(),
                'clave_productos' => ClaveProducto::all(),
                'clave_unidades' => ClaveUnidad::all(),
            ]);
        }
        else{
            return view('livewire.equipos.view',[
                'equipos' => Equipo::orderBy('descripcion', 'asc')
                ->orWhere('descripcion', 'LIKE', '%'.$this->searchValueEquipos.'%')
                ->get(),
            ]);
        }
    }

    public function loadEquipo($id){
        if($id == 0){
            $this->equipo = new Equipo();
        }
        else{
            $this->equipo = Equipo::findOrFail($id);
        }
    }

    public function saveEquipo(){
        $this->validate([
            'equipo.familia_id' => 'integer|min:1',
            'equipo.modelo' => 'string',
            'equipo.serie' => 'string',
            'equipo.year' => 'numeric',
            'equipo.cantidad' => 'integer',
            'equipo.descripcion' => 'string',
            'equipo.origen' => 'string',
            'equipo.factura' => 'string',
            'equipo.pedimento' => 'string',
            'equipo.fecha_adquisicion' => 'string',
            'equipo.horometro' => 'integer',
            'equipo.placas' => 'string',
            'equipo.moneda' => 'string',
            'equipo.cotizacion_usd' => 'numeric',
            'equipo.valor_compra' => 'numeric',
            'equipo.valor_traslado' => 'numeric',
            'equipo.valor_importacion' => 'numeric',
            'equipo.renta_hora' => 'numeric',
            'equipo.renta_dia' => 'numeric',
            'equipo.renta_semana' => 'numeric',
            'equipo.renta_mes' => 'numeric',
            'equipo.propietario' => 'string',
            'equipo.activo' => 'boolean',
            'equipo.clave_producto_id' => 'integer|required',
            'equipo.clave_unidad_id' => 'integer|required',
        ]);

        if(!isset($this->equipo->id)){
            $fam = Familia::findOrFail($this->equipo->familia_id);
            $this->equipo->fua = $fam->abreviacion;
            $this->equipo->fua .= str_pad($fam->siguiente_folio, 6, '0', STR_PAD_LEFT);
        }
        

        if($this->equipo->save()){
            if(isset($fam)){
                $fam->siguiente_folio++;
                $fam->save();
            }

            $this->emit('ok','Se ha guardado Equipo: '. strtoupper($this->equipo->descripcion));
            $this->equipo = null;
        }
    }

    public function cancel(){
        $this->resetInput();
    }

    public function resetInput(){
        $this->equipo = null;
    }
}
