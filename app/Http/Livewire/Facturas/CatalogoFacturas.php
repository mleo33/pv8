<?php

namespace App\Http\Livewire\Facturas;

use App\Exports\FacturasExport;
use App\Http\Controllers\FacturaController;
use App\Models\Factura;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class CatalogoFacturas extends Component
{
    public Factura $factura;
    public $startDate;
    public $endDate;
    public $keyWord;

    protected $listeners = [
        'cancelacionSuccess',
        'cancelarFactura',
    ];

    protected $rules = [
        'factura.entidad_fiscal.correo' => 'string',
    ];


    // public function updatedKeyWord(){
    //     $this->resetPage($this->pageName);
    // }

    public function mount(){
        $this->startDate = Carbon::today()->startOfMonth()->toDateString();
        $this->endDate = Carbon::today()->endOfMonth()->toDateString();
        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.facturas.catalogo-facturas.view', $this->getRenderData());
    }

    public function getRenderData(){
        $facturas = Factura::orderBy('id', 'desc')
        ->whereBetween('created_at', [$this->startDate, ($this->endDate . ' 23:59:59')]);
        if($this->keyWord){
            $facturas->whereHas('entidad_fiscal', function($query){
                $query->where('rfc', 'like', '%' . $this->keyWord . '%')
                ->orWhere('razon_social', 'like', '%' . $this->keyWord . '%')
                ->orWherehas('model', function($query){
                    $query->where('nombre', 'like', '%' . $this->keyWord . '%');
                });
            })
            ->orWhere('folio', 'like', $this->keyWord . '');
        }
        
        return [
            'facturas' => $facturas->get(),
        ];
    }

    public function cancel(){
        $this->resetInput();
    }

    public function resetInput(){
        $this->factura = new Factura();
    }

    public function viewRegistros($id){
        //$this->renta = Factura::findOrFail($id);
        //$this->emit('showModal', '#mdlRentDetails');
    }

    public function mdlEnviarFactura(Factura $factura){
        $this->resetValidation();
        $this->factura = $factura;
        $this->factura->load('entidad_fiscal');
        $this->emit('showModal', '#mdlEnviarFactura');
    }

    public function enviarCorreo(){
        $this->validate([
            'factura.entidad_fiscal.correo' => 'email|required',
        ]);
        FacturaController::enviarCorreo($this->factura);
        $this->emit('ok', 'Se ha enviado factura a ' . $this->factura->entidad_fiscal->correo, 'Factura #' . $this->factura->id . ' Enviada');
    }

    public function cancelarFactura($id){
        // $factura = Factura::findOrFail($id);
        // $title = "Cancelar Factura {$factura->no_factura}";
        // $data = [
        //     'factura_id' => $factura->id,
        //     'folio_sustitucion' => '1234-5678-1234-5678',
        //     'motivo' => '02',
        // ];

        // $this->emit('post-cancelar-factura', $data, $title, csrf_token(), 'canceladoSuccess');
    }

    public function cancelacionSuccess(){
        //limpiar
    }

    public function showMdlMail($id){
        $factura = Factura::findOrFail($id);
        $title = "Envio de Factura (CFDI)";
        $message = "Factura # {$factura->no_factura}\n\n";
        $message .= "Se ha generado factura para:  {$factura->entidad_fiscal->model->nombre}\n";
        $message .= "RFC: {$factura->entidad_fiscal->rfc}\n";
        $message .= "Razón Social:  {$factura->entidad_fiscal->razon_social}\n";

        $to = $factura->entidad_fiscal->correo;

        $this->emit('initMdlEnviarCorreo', $id, Factura::class, $title, $message, $to);

    }

    public function exportToExcel(){
        return Excel::download(new FacturasExport($this->startDate, $this->endDate), 'reporte_facturas.xlsx');
    }
}
