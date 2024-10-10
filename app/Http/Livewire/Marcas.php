<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Marca;

class Marcas extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre;
    public $updateMode = false;

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.marcas.view', [
            'marcas' => Marca::orderBy('nombre', 'ASC')
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
    }

    public function store()
    {
        $this->validate([
		'nombre' => 'required',
        ]);

        Marca::create([ 
			'nombre' => strtoupper($this->nombre),
        ]);
        
        
        
		$this->emit('closeModal');
        $this->emit('ok', 'Se ha agregado marca: ' . strtoupper($this->nombre));
		$this->resetInput();
    }

    public function edit($id)
    {
        $record = Marca::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre = $record-> nombre;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombre' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Marca::find($this->selected_id);
            $record->update([ 
                'nombre' => strtoupper($this->nombre),
            ]);

		    $this->emit('closeModal');
            $this->emit('ok', 'Se ha editado marca: ' . strtoupper($this->nombre));
            $this->resetInput();
            $this->updateMode = false;
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Marca::where('id', $id);
            $record->delete();
        }
    }
}
