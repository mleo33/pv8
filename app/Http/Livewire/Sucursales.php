<?php

namespace App\Http\Livewire;

use App\Models\Emisor;
use App\Models\Sucursal;
use Livewire\Component;

use Livewire\WithPagination;

class Sucursales extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $keyWord;
    public $activeTab = 1;

    public Sucursal $sucursal;
    
    protected $rules = [
        'sucursal.nombre' => 'string|required|max:255|unique:sucursales',
        'sucursal.direccion' => 'string',
        'sucursal.telefono' => 'string',
        'sucursal.emisor_id' => 'numeric',
        'sucursal.comentarios' => 'string',
        'sucursal.tasa_iva' => 'numeric',
        'sucursal.mensaje_ticket_venta' => 'string',
    ];

    protected $listeners = [
        'destroy' => 'destroy'
    ];

    public function mount(){
        $this->resetInput();
    }

    public function resetInput(){
        $this->sucursal = new Sucursal();
    }

    public function cancel(){
        $this->resetInput();
        $this->resetValidation();
    }

    public function render()
    {;
        return view('livewire.sucursales.view', [
            'sucursales' => Sucursal::orderBy('id', 'asc')->orWhere('nombre', 'like', '%' . $this->keyWord . '%')->paginate(10),
            'emisores' => Emisor::all(),
        ]);
    }

    public function save(){
        $this->sucursal->emisor_id = $this->sucursal->emisor_id == 0 ? null : $this->sucursal->emisor_id;
        $rules = [
            'sucursal.nombre' => "required|unique:sucursales" . ($this->sucursal->id ? ",nombre,{$this->sucursal->id}" : ""),
            'sucursal.direccion' => 'string|max:255',
            'sucursal.telefono' => 'string|max:20',
            'sucursal.emisor_id' => 'numeric|nullable',
            'sucursal.comentarios' => 'string',
            'sucursal.tasa_iva' => 'numeric|required|min:8|max:16',
        ];
        $messages = [
            'nombre.required' => 'Escriba el nombre de la sucursal',
            'nombre.unique' => 'Ya existe una sucursal con ese nombre',
        ];
        $this->validate($rules, $messages);

        if($this->sucursal->save()){
            $this->emit('ok','Se ha guardado sucursal '. $this->sucursal->nombre);
            $this->cancel();
            $this->emit('closeModal', '#mdl');
        }
    }

    public function viewUsers($id)
    {
        $this->sucursal = Sucursal::findOrFail($id);
        if($this->sucursal->users->count() > 0)
        {
            $this->emit('showModal', '#mdlUsers');
        }
        else{
             $this->emit('info', 'No existen usuarios asignados a este rol', strtoupper($this->role->name));
        }
    }

    public function edit($id)
    {
        if($id == 0){
            $this->cancel();
        }
        else{
            $this->sucursal = Sucursal::findOrFail($id);
            $this->emit('showModal', '#mdl');
        }
    }

    public function update()
    {
        $rules = [
            'nombre' => "required|unique:sucursales,nombre,{$this->selected_id}"
        ];

        $messages = [
            'nombre.required' => 'Escriba el nombre de la sucursal',
            'nombre.unique' => 'Ya existe una sucursal con ese nombre',
        ];

        $this->validate($rules, $messages);


        $sucursal = Sucursal::find($this->selected_id);
        $sucursal->update([
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'comentarios' => $this->comentarios,
        ]);

        $this->emit('closeModal');
        $this->emit('ok', 'Se ha editado categoria: ' . strtoupper($this->nombre));
        $this->resetInput();
        $this->updateMode = false;
    }

    public function destroy(Sucursal $sucursal)
    {
        $sucursal->delete();
        $this->resetInput();
    }
}
