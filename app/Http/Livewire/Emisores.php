<?php

namespace App\Http\Livewire;

use App\Models\Emisor;
use Livewire\Component;
use Livewire\WithPagination;
use App\Classes\FacturacionConstants;

class Emisores extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $regimenes_fiscales = FacturacionConstants::REGIMENES_FISCALES;

    public $keyWord;
    public Emisor $emisor;

    protected $rules = [
        'emisor.nombre' => 'string|required|max:255',
        'emisor.rfc' => 'string|required|max:15',
        'emisor.regimen_fiscal' => 'string|required',
        'emisor.lugar_expedicion' => 'string|required',
        'emisor.serie' => 'string|required|max:6',
        'emisor.serie_complementos' => 'string|required|max:6',
        'emisor.folio_facturas' => 'numeric|required|min:1',
        'emisor.folio_complementos' => 'numeric|required|min:1',
        'emisor.no_certificado' => 'string|required|max:50',
        'emisor.clave_certificado' => 'string|required|max:50',
        'emisor.fd_user' => 'string|required|max:50',
        'emisor.fd_pass' => 'string|required|max:50',
    ];

    protected $listeners = [
        'destroy' => 'destroy',
    ];

    public function mount(){
        $this->resetInput();
    }

    public function render(){
        return view('livewire.emisores.view', [
            'emisores' => Emisor::orderBy('id', 'ASC')
            ->orWhere('nombre', 'LIKE', '%'.$this->keyWord .'%')->paginate(15),
        ]);
    }

    public function resetInput(){
        $this->emisor = new Emisor();
    }

    public function cancel(){
        $this->resetInput();
        $this->resetValidation();
    }

    public function edit($id){
        if($id == 0){
            $this->cancel();
        }
        else{
            $this->emisor = emisor::findOrFail($id);
            $this->emit('showModal', '#mdl');
        }
    }

    public function save(){
        $this->validate();

        if($this->emisor->save()){
            $this->emit('ok','Se ha guardado emisor '. $this->emisor->nombre);
            $this->cancel();
            $this->emit('closeModal', '#mdl');
        }
    }

    public function viewSucursales($id_emisor){
        $this->emisor = Emisor::findOrFail($id_emisor);
        $this->emit('showModal', '#mdlSucursales');
    }

    public function destroy($id){
        if ($id) {
            $record = Emisor::where('id', $id)->first();

            if($record->delete()){
                $this->emit('ok', 'Se ha eliminado emisor: ' . $record->nombre);
            }
        }
    }
}
