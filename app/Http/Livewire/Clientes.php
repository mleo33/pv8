<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Cliente;
use App\Models\EntidadFiscal;
use App\Models\ReferenciaCliente;
use App\Models\Telefono;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Clientes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $keyWord;
    public $activeTab = 1;

    public Cliente $cliente;
    public Telefono $telefono;
    public ReferenciaCliente $referencia;
    public EntidadFiscal $entidadFiscal;

    public $editMode = false;
    
    protected $listeners = [
        'destroy' => 'destroy',
        'destroyTelefono' => 'destroyTelefono',
        'destroyEntidadFiscal' => 'destroyEntidadFiscal',
        'destroyReferencia' => 'destroyReferencia',
    ];

    protected $rules = [
        'cliente.nombre' => 'string',
        'cliente.direccion' => 'string',
        'cliente.correo' => 'email',
        'cliente.limite_credito' => 'numeric',
        'cliente.dias_credito' => 'numeric',
        'cliente.comentarios' => 'string',
        'telefono.tipo' => 'string',
        'telefono.numero' => 'numeric',
        'telefono.notas' => 'string',
        
        'entidadFiscal.razon_social' => 'string',
        'entidadFiscal.regimen_fiscal' => 'string',
        'entidadFiscal.calle' => 'string',
        'entidadFiscal.numero' => 'string',
        'entidadFiscal.numero_int' => 'string',
        'entidadFiscal.colonia' => 'string',
        'entidadFiscal.cp' => 'string',
        'entidadFiscal.ciudad' => 'string',
        'entidadFiscal.estado' => 'string',
        'entidadFiscal.rfc' => 'string',
        'entidadFiscal.correo' => 'string',
        'entidadFiscal.comentarios' => 'string',

        'referencia.nombre' => 'string',
        'referencia.direccion' => 'string',
        'referencia.telefono1' => 'string',
        'referencia.telefono2' => 'string',
        'referencia.notas' => 'string',
    ];

    public function mount(){
        $this->resetInput();
    }

    public function render(){

        if(isset($this->cliente->id) && $this->editMode){
            return view('livewire.clientes.edit');
        }
        else{
            $keyWord = '%' . $this->keyWord . '%';
            return view('livewire.clientes.view', [
                'clientes' => Cliente::orderBy('id', 'desc')
                    ->orWhere('nombre', 'LIKE', $keyWord)
                    ->paginate(25),
            ]);
        }
    }

    public function cancel(){
        $this->resetInput();
        $this->resetValidation();
    }

    public function cancelTelefono(){
        $this->telefono = new Telefono();
        $this->telefono->tipo = "CELULAR";
        $this->resetValidation();
    }

    public function cancelEntidadFiscal(){
        $this->entidadFiscal = new EntidadFiscal();
        $this->resetValidation();
    }

    public function cancelReferencia(){
        $this->referencia = new ReferenciaCliente();
        $this->resetValidation();
    }

    private function resetInput(){
        $this->editMode = false;
        $this->cliente = new Cliente();
        $this->entidadFiscal = new EntidadFiscal();
        $this->referencia = new ReferenciaCliente();
        $this->telefono = new Telefono();
        $this->telefono->tipo = "CELULAR";
        $this->activeTab = 1;
    }

    public function saveCliente(){
        $new = !isset($this->cliente->id);

        $valid = [
            'cliente.nombre' => 'string|required',
            'cliente.direccion' => 'string|required',
            'cliente.correo' => 'email|nullable',
            'cliente.limite_credito' => 'numeric|required|min:0',
            'cliente.dias_credito' => 'numeric|required|min:0|max:365',
            'cliente.comentarios' => 'string|nullable',
        ];

        if($new){
            $valid = array_merge($valid,[
                'telefono.tipo' => 'string',
                'telefono.numero' => 'string|nullable|min:10'
            ]);
        }

        $this->validate($valid);

        if($this->cliente->save()){
            $this->emit('ok','Se ha guardado cliente: '. $this->cliente->nombre);
            $this->emit('closeModal', '#mdl');
            if($new && $this->telefono->numero != null){
                $this->telefono->model_id = $this->cliente->id;
                $this->telefono->model_type = Cliente::class;
                $this->telefono->save();
                $this->resetInput();
            }
        }
    }

    public function edit($id){
        if($id == 0){
            $this->resetInput();
        }
        else{
            $this->cliente = Cliente::findOrFail($id);
            $this->editMode = true;
        }
    }

    public function saveTelefono(){

        $this->validate([
            'telefono.tipo' => 'string|required',
            'telefono.numero' => 'string|required|min:10',
            'telefono.notas' => 'string|nullable|max:255',
        ]);

        $this->telefono->model_id = $this->cliente->id;
        $this->telefono->model_type = Cliente::class;

        if($this->telefono->save()){
            $this->emit('ok','Se ha guardado teléfono');
            $this->emit('closeModal', '#mdlTelefono');
            $this->telefono = new Telefono();
            $this->edit($this->cliente->id);
        }
    }

    public function editTelefono($id){
        $this->telefono = Telefono::find($id);
        $this->emit('showModal', '#mdlTelefono');
    }

    public function saveEntidadFiscal(){
        $this->validate([
            'entidadFiscal.razon_social' => 'string|required|max:255',
            'entidadFiscal.regimen_fiscal' => 'string|required',
            'entidadFiscal.calle' => 'string|required|max:255',
            'entidadFiscal.numero' => 'string|required|max:255',
            'entidadFiscal.numero_int' => 'string|nullable|max:255',
            'entidadFiscal.colonia' => 'string|required|max:255',
            'entidadFiscal.cp' => 'string|required|max:255',
            'entidadFiscal.ciudad' => 'string|required|max:255',
            'entidadFiscal.estado' => 'string|required|max:255',
            'entidadFiscal.rfc' => 'string|required|max:255',
            'entidadFiscal.correo' => 'email|required|max:255',
        ]);

        $this->entidadFiscal->model_id = $this->cliente->id;
        $this->entidadFiscal->model_type = Cliente::class;
        $this->entidadFiscal->razon_social = Str::upper($this->entidadFiscal->razon_social);
        $this->entidadFiscal->regimen_fiscal = Str::upper($this->entidadFiscal->regimen_fiscal);
        $this->entidadFiscal->calle = Str::upper($this->entidadFiscal->calle);
        $this->entidadFiscal->colonia = Str::upper($this->entidadFiscal->colonia);
        $this->entidadFiscal->ciudad = Str::upper($this->entidadFiscal->ciudad);
        $this->entidadFiscal->estado = Str::upper($this->entidadFiscal->estado);
        $this->entidadFiscal->rfc = Str::upper($this->entidadFiscal->rfc);
        $this->entidadFiscal->correo = Str::lower($this->entidadFiscal->correo);

        if($this->entidadFiscal->save()){
            $this->emit('ok','Se ha guardado entidad fiscal');
            $this->emit('closeModal', '#mdlEntidadFiscal');
            $this->entidadFiscal = new EntidadFiscal();
            $this->edit($this->cliente->id);
        }
    }

    public function editEntidadFiscal($id){
        $this->entidadFiscal = EntidadFiscal::find($id);
        $this->emit('showModal', '#mdlEntidadFiscal');
    }

    public function showTelefonos($id){
        $this->cliente = Cliente::findOrFail($id);
        $this->emit('showModal', '#mdlTelefonos');
    }

    public function destroy($id){
        if ($id) {
            $record = Cliente::where('id', $id)->first();
            foreach($record->telefonos as $telefono){
                $telefono->delete();
            }
            foreach($record->entidades_fiscales as $entidad){
                $entidad->delete();
            }
            if($record->delete()){
                $this->emit('ok', 'Se ha eliminado cliente: ' . $record->nombre);
            }
        }
    }

    public function destroyTelefono($id){
        if ($id) {
            $record = Telefono::where('id', $id)->first();
            if($record->delete()){
                $this->emit('ok', 'Se ha eliminado teléfono');
                $this->edit($this->cliente->id);
            }
        } 
    }

    public function destroyEntidadFiscal($id){
        if ($id) {
            $record = EntidadFiscal::where('id', $id)->first();
            if($record->delete()){
                $this->emit('ok', 'Se ha eliminado entidad fiscal');
                $this->edit($this->cliente->id);
            }
        } 
    }


    public function saveReferencia(){
        $this->validate([
            'referencia.nombre' => 'string|required|min:10|max:255',
            'referencia.direccion' => 'string|nullable|max:255',
            'referencia.telefono1' => 'string|required|min:10|max:15',
            'referencia.telefono2' => 'string|nullable|min:10|max:15',
            'referencia.notas' => 'string|nullable|max:255',
        ]);

        $this->referencia->cliente_id = $this->cliente->id;

        if($this->referencia->save()){
            $this->emit('ok','Se ha guardado referencia');
            $this->emit('closeModal', '#mdlReferencia');
            $this->referencia = new ReferenciaCliente();
            $this->edit($this->cliente->id);
        }
    }

    public function editReferencia($id){
        $this->referencia = ReferenciaCliente::find($id);
        $this->emit('showModal', '#mdlReferencia');
    }

    public function destroyReferencia($id){
        if ($id) {
            $record = ReferenciaCliente::where('id', $id)->first();
            if($record->delete()){
                $this->emit('ok', 'Se ha eliminado referencia');
                $this->edit($this->cliente->id);
            }
        } 
    }
}
