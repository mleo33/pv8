<?php

namespace App\Http\Livewire\Factura;

use App\Classes\FacturacionConstants;
use App\Models\Complemento;
use App\Models\Factura;
use Livewire\Component;
use Livewire\WithPagination;

class MdlCancelarFactura extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $keyWord;
    public $factura;
    public $tipo;
    public $selectedFactura;
    public $mdlName = 'mdlCancelarFactura';
    public $tipoCancelacion;
    public $tipos_cancelacion = FacturacionConstants::TIPO_CANCELACION;

    protected $listeners = [
        'initMdlCancelarFactura',
        'cancelacionSuccess',
    ];

    public function updatedKeyWord(){
        $this->resetPage('factSustPage');
    }

    public function mount(){
        $this->factura = new Factura();
    }

    public function initMdlCancelarFactura($factura_id, $type){
        $this->tipo = strtoupper($type);

        if($this->tipo == 'FACTURA'){
            $this->factura = Factura::findOrFail($factura_id);
        }
        if($this->tipo == 'PAGO'){
            $this->factura = Complemento::findOrFail($factura_id);
        }
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function render()
    {
        return view('livewire.factura.mdl-cancelar-factura',$this->getRenderData());
    }

    public function getRenderData(){
        $model = Factura::class;
        if($this->tipo == "PAGO"){
            $model = Complemento::class;
        }
        
        return [
            'facturas' => $model::where('estatus', 'TIMBRADO')
            ->where(function($q){
                $q->WhereHas('entidad_fiscal', function($c){
                    $c->orWhere('rfc', 'LIKE', "%{$this->keyWord}%");
                    $c->orWhere('razon_social', 'LIKE', "%{$this->keyWord}%");
                });
            })
            ->paginate(50, ['*'], 'factSustPage'),
        ];
    }

    public function showCancelarButton(){
        if($this->tipoCancelacion == ''){
            return false;
        }
        if($this->tipoCancelacion == '1' && !$this->selectedFactura){
            return false;
        }

        return true;
    }

    public function setFacturaSustitution($id){
        if($id > 0){
            if($this->tipo == "FACTURA"){
                $this->selectedFactura = Factura::findOrFail($id);
            }
            if($this->tipo == "PAGO"){
                $this->selectedFactura = Complemento::findOrFail($id);
            }
        }
        else{
            $this->selectedFactura = null;
        }
    }

    public function cancelarFactura(){
        $title = 'Cancelar factura por $' . number_format($this->factura->total, 2);
        $data = [
            'factura_id' => $this->factura->id,
            'motivo' => $this->tipoCancelacion,
            'folio_sustitucion' => $this->selectedFactura?->uuid,
        ];
        $this->emit('post-cancelar-factura', $data, $title, csrf_token(), 'cancelacionSuccess');
    }

    public function cancelacionSuccess(){
        $this->render();
    }


}
