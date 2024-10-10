<?php

namespace App\Http\Livewire;

use App\Models\Traslado;
use Illuminate\Support\Str;
use Livewire\Component;

class Traslados extends Component
{
    public $keyWord;
    public Traslado $traslado;

    protected $rules = [
        'traslado.destino' => 'string|required|max:255',
        'traslado.sencillo' => 'numeric|required|min:0',
        'traslado.redondo' => 'numeric|required|min:0',
        'traslado.comentarios' => 'string|nullable|max:255',
    ];

    protected $listeners = [
        'destroy' => 'destroy',
    ];

    public function mount(){
        $this->resetInput();
    }

    public function render(){
        return view('livewire.traslados.view', [
            'traslados' => Traslado::orderBy('destino', 'ASC')
            ->orWhere('destino', 'LIKE', '%'.$this->keyWord .'%')->paginate(100),
        ]);
    }

    public function resetInput(){
        $this->traslado = new Traslado();
    }

    public function cancel(){
        $this->resetInput();
        $this->resetValidation();
    }

    public function edit($id){
        if($id == 0){
            $this->resetInput();
        }
        else{
            $this->traslado = Traslado::findOrFail($id);
            $this->emit('showModal', '#mdl');
        }
    }

    public function save(){
        $this->validate();
        
        $this->traslado->destino = Str::upper($this->traslado->destino);

        if($this->traslado->save()){
            $this->emit('ok','Se ha guardado traslado a '. $this->traslado->destino);
            $this->resetInput();
            $this->emit('closeModal', '#mdl');
        }
    }

    public function destroy($id){
        if ($id) {
            $record = Traslado::where('id', $id)->first();

            if($record->delete()){
                $this->emit('ok', 'Se ha eliminado traslado a ' . $record->destino);
            }
        }
    }
}
