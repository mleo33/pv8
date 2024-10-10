<?php

namespace App\Http\Livewire;

use Livewire\Component;

//
use App\Models\Proveedor;
use Livewire\WithPagination;

class Proveedores extends Component
{    
    use WithPagination;

	protected $paginationTheme = 'bootstrap';

    public $selected_id, $keyWord;
    public $nombre, $calle, $numero, $numero_int, $colonia, $cp, $ciudad, $estado, $rfc, $telefono, $correo, $comentarios;
    public $updateMode = false;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        return view('livewire.proveedores.view', [
            'proveedores' => Proveedor::orderBy('id', 'desc')
            ->orWhere('nombre', 'LIKE', $keyWord)
            ->paginate(25),
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
        $this->resetValidation();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->nombre = null;
        $this->calle = null;
        $this->numero = null;
        $this->numero_int = null;
        $this->colonia = null;
        $this->cp = null;
        $this->ciudad = null;
        $this->estado = null;
        $this->rfc = null;
        $this->telefono = null;
        $this->correo = null;
        $this->comentarios = null;
    }

    public function store()
    {
        $this->validate([
		    'nombre' => 'required',
            'correo' => 'unique:clientes'
        ]);

        Proveedor::create([ 
			'nombre' => $this->nombre,
            'calle' => $this->calle,
            'numero' => $this->numero,
            'numero_int' => $this->numero_int,
            'colonia' => $this->colonia,
            'cp' => $this->cp,
            'ciudad' => $this->ciudad,
            'estado' => $this->estado,
            'rfc' => $this->rfc,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'comentarios' => $this->comentarios,
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
        $this->emit('ok', 'Se ha agregado cliente ' . $this->nombre);
		session()->flash('message', 'Marca Successfully created.');
    }

    public function edit($id)
    {
        $record = Proveedor::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre = $record->nombre;
        $this->calle = $record->calle;
        $this->numero = $record->numero;
        $this->numero_int = $record->numero_int;
        $this->colonia = $record->colonia;
        $this->cp = $record->cp;
        $this->ciudad = $record->ciudad;
        $this->estado = $record->estado;
        $this->rfc = $record->rfc;
        $this->telefono = $record->telefono;
        $this->correo = $record->correo;
        $this->comentarios = $record->comentarios;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		    'nombre' => 'required',
            'correo' => "unique:proveedores,correo,{$this->selected_id}"
        ]);

        if ($this->selected_id) {
			$record = Proveedor::find($this->selected_id);
            $record->update([ 
			    'nombre' => $this->nombre,
                'calle' => $this->calle,
                'numero' => $this->numero,
                'numero_int' => $this->numero_int,
                'colonia' => $this->colonia,
                'cp' => $this->cp,
                'ciudad' => $this->ciudad,
                'estado' => $this->estado,
                'rfc' => $this->rfc,
                'telefono' => $this->telefono,
                'correo' => $this->correo,
                'comentarios' => $this->comentarios,
            ]);

            $this->emit('closeModal');
            $this->emit('ok', 'Se ha editado cliente ' . $this->nombre);
            $this->resetInput();
            $this->updateMode = false;
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Proveedor::where('id', $id);
            $record->delete();
        }
    }
}
