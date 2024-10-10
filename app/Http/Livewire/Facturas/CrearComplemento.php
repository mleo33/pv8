<?php

namespace App\Http\Livewire\Facturas;

use App\Classes\FacturacionConstants;
use App\Http\Controllers\ComplementoController;
use App\Models\Complemento;
use App\Models\Factura;
use Livewire\Component;

class CrearComplemento extends Component
{
    public Factura $factura;
    public $selectedComplemento;
    public $formas_pago = FacturacionConstants::FORMAS_PAGO;
    
    public $FechaPago;
    public $Monto;
    public $FormaDePagoP;
    public $NumOperacion;
    public $RfcEmisorCtaOrd;
    public $RfcEmisorCtaBen;
    public $CtaOrdenante;
    public $CtaBeneficiario;

    public $ImpSaldoAnt;
    public $ImpPagado;
    public $ImpSaldoInsoluto;
    public $NumParcialidad;

    protected $listeners = [
        'success' => 'success'
    ];

    protected $rules = [
        'FechaPago' => 'date',
        'Monto' => 'numeric',
        'FormaDePagoP' => 'string',
        'NumOperacion' => 'string',
        'RfcEmisorCtaOrd' => 'string',
        'RfcEmisorCtaBen' => 'string',
        'CtaOrdenante' => 'string',
        'CtaBeneficiario' => 'string',
        'NumParcialidad' => 'numeric',
        'factura.entidad_fiscal.correo' => 'string',

    ];

    public function mount($factura){
        $this->factura = $factura;
        $this->FechaPago = date("Y-m-d");
        $this->Monto = $factura->total;

        $complementos = $factura->complementos->where('estatus', 'TIMBRADO');
        $this->ImpPagado = $complementos->sum('monto');
        $this->ImpSaldoAnt = $factura->total - $this->ImpPagado;
    }
    
    public function render()
    {
        return view('livewire.facturas.crear_complemento.view');
    }

    public function generarComplemento(){
        $this->validate([
            'FechaPago' => 'date|required',
            'Monto' => 'numeric|min:0.1|max:' . $this->ImpSaldoAnt,
            'FormaDePagoP' => 'string|required',
        ]);
        
        $this->emit('post-complemento', [
            'title' => 'Complemento de Pago: $' . number_format($this->Monto, 2),
            'factura_id' => $this->factura->id,
            'serie' => $this->factura->serie,
            'folio' => $this->factura->folio,
            'FechaPago' => $this->FechaPago,
            'Monto' => $this->Monto,
            'FormaDePagoP' => $this->FormaDePagoP,
            'NumOperacion' => $this->NumOperacion,
            'RfcEmisorCtaOrd' => $this->RfcEmisorCtaOrd,
            'RfcEmisorCtaBen' => $this->RfcEmisorCtaBen,
            'CtaOrdenante' => $this->CtaOrdenante,
            'CtaBeneficiario' => $this->CtaBeneficiario,
            'ImpSaldoAnt' => $this->ImpSaldoAnt,
            'ImpPagado' => $this->ImpPagado + $this->Monto,
            'ImpSaldoInsoluto' => $this->ImpSaldoAnt - $this->Monto,
            'NumParcialidad' => $this->factura->complementos->count() + 1,
        ], csrf_token(), 'success');
    }

    public function success($id){
        // $this->emit('alert', $id);
    }

    public function mdlEnviarComplemento(Complemento $complemento){
        $this->resetValidation();
        $this->selectedComplemento = $complemento;
        $this->factura->load('entidad_fiscal');
        $this->emit('showModal', '#mdlEnviarFactura');
    }

    public function enviarCorreo(){
        $this->validate([
            'factura.entidad_fiscal.correo' => 'email|required',
        ]);
        ComplementoController::enviarCorreo($this->selectedComplemento);
        $this->emit('ok', 'Se ha enviado complemento de pago a ' . $this->factura->entidad_fiscal->correo, 'Complemento ' . $this->selectedComplemento->no_complemento . ' Enviada');
    }
}
