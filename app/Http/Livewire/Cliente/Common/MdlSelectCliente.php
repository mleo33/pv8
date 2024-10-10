<?php

namespace App\Http\Livewire\Cliente\Common;

use App\Models\Cliente;
use App\Models\Telefono;
use Livewire\Component;
use Livewire\WithPagination;

class MdlSelectCliente extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public Cliente $cliente;
    public $telefono;
    public $createMode = false;

    public $mdlName = 'mdlSelectCliente';
    public $pageName = 'selectClientePage';
    public $successAction = 'setCliente';
    public $keyWord;

    protected $listeners = [
      'initMdlSelectCliente',
    ];

    protected $rules = [
        'cliente.nombre' => 'string|required',
        'cliente.direccion' => 'string|required',
        'cliente.correo' => 'email|required',
        'cliente.limite_credito' => 'numeric|required|min:0|max:9999999',
        'cliente.dias_credito' => 'numeric|required|min:0|max:365',
        'cliente.comentarios' => 'string|nullable|max:5000',

        'telefono.tipo' => 'string|required',
        'telefono.numero' => 'numeric|required|digits_between:10,15',
    ];

    public function mount(){
        $this->cliente = new Cliente();
    }

    public function initMdlSelectCliente(){
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function updatedKeyWord(){
        $this->resetPage($this->pageName);
    }

    public function render()
    {
        return view('livewire.cliente.common.mdl-select-cliente', $this->getRenderData());
    }

    public function getRenderData(){
        return [
            'clientes' => Cliente::OrderBy('nombre')
            ->where('canceled_at', null)
            ->where(function($q){
                $q->orWhere('id', $this->keyWord);
                $q->orWhere('nombre', 'LIKE', "%{$this->keyWord}%");
                $q->orWhere('direccion', 'LIKE', "%{$this->keyWord}%");
                $q->orWhere('correo', 'LIKE', "%{$this->keyWord}%");
            })
            
            ->paginate(50, ['*'], 'selectClientePage'),
        ];
    }

    public function select($id){
        $this->emit($this->successAction, $id);
        $this->emit('closeModal', "#{$this->mdlName}");
    }

    public function create(){
        $this->validate();
        if($this->cliente->save()){
            Telefono::create([
                'model_id' => $this->cliente->id,
                'model_type' => Cliente::class,
                'tipo' => $this->telefono['tipo'],
                'numero' => $this->telefono['numero'],
                'notas' => "Tel. Principal",
            ]);

            $this->emit('ok', "Se ha creado cliente: {$this->cliente->nombre}");
            $this->emit($this->successAction, $this->cliente->id);
            $this->emit('closeModal', "#{$this->mdlName}");
        }
        $this->cliente = new Cliente();
        $this->createMode = false;
    }
}
