<?php

namespace App\Http\Livewire\Cotizacion;

use App\Http\Livewire\Classes\LivewireBaseCrudController;
use App\Models\Cotizacion;
use Carbon\Carbon;

class CatalogoCotizaciones extends LivewireBaseCrudController
{
    protected $model_name = "Cotización";
    protected $model_name_plural = "Cotizaciones";

    public $startDate;
    public $endDate;

    protected $listeners = [
        'updateCatalogoCotizaciones',
        'send' => 'sendMail',
    ];
    
    public function mount(){
        Parent::mount();
        $this->startDate = Carbon::today()->startOfMonth()->toDateString();
        $this->endDate = Carbon::today()->endOfMonth()->toDateString();
    }

    public function updateCatalogoCotizaciones(){
        $this->render();
    }

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Cotizacion();
    }

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('id', 'ASC')
        ->whereBetween('created_at', [$this->startDate, ($this->endDate . ' 23:59:59')])
        ->paginate(100);
        return view('livewire.cotizacion.catalogo-cotizaciones.view', compact('data'));
    }

    public function mdlEnviarCorreo($id){
        $this->model = $this->model::findOrFail($id);
        $mail = $this->model->cliente->correo;
        $mailBody = "Se ha generado cotización para: {$this->model->cliente->nombre}";
        $mailBody .= "\n\nMas información en el documento adjunto";
        $this->emit('initMdlEnviarCotizacionCorreo', $this->model, $mail, $mailBody);
    }
}
