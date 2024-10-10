<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Familia;

class Familias extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre;
    public $abreviacion;
    public $updateMode = false;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.familias.view', [
            'familias' => Familia::orderBy('nombre', 'ASC')
            ->orWhere('nombre', 'LIKE', $keyWord)->paginate(100),
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->nombre = null;
        $this->abreviacion = null;
    }

    public function store()
    {
        $validation_params = [
            'nombre' => 'required|unique:familias,nombre,' . $this->selected_id,
            'abreviacion' => 'required|min:4|max:6|unique:familias,abreviacion,' . $this->selected_id,
        ];

        $this->validate($validation_params);

        Familia::create([ 
			'nombre' => $this->nombre,
            'abreviacion' => $this->abreviacion,
        ]);
        
		$this->emit('closeModal');
        $this->emit('ok', 'Se ha agregado familia: ' . strtoupper($this->nombre));
		$this->resetInput();
    }

    public function edit($id)
    {
        $record = Familia::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre = $record->nombre;
        $this->abreviacion = $record->abreviacion;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $validation_params = [
            'nombre' => 'required|unique:familias,nombre,' . $this->selected_id,
            'abreviacion' => 'required|min:4|max:6|unique:familias,abreviacion,' . $this->selected_id,
        ];

        $this->validate($validation_params);

        if ($this->selected_id) {
			$record = Familia::find($this->selected_id);
            $record->update([ 
                'nombre' => $this->nombre,
                'abreviacion' => $this->abreviacion,
            ]);

		    $this->emit('closeModal');
            $this->emit('ok', 'Se ha editado familia: ' . strtoupper($this->nombre));
            $this->resetInput();
            $this->updateMode = false;
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Familia::where('id', $id);
            $record->delete();
        }
    }
}
