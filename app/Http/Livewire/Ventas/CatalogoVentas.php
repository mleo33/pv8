<?php

namespace App\Http\Livewire\Ventas;

use App\Classes\DataExporter;
use App\Models\User;
use App\Models\Venta;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoVentas extends Component
{
    use WithPagination;
    protected $listeners = ['cancelarVenta'];

    protected $paginationTheme = 'bootstrap';

    public $venta;
    public $user_id;

    public $dateStart;
    public $dateEnd;

    public $keyWord;

    public function mount(){
        $this->dateStart = date('Y-m-d');
        $this->dateEnd = date('Y-m-d');
    }

    public function updatingKeyWord(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.ventas.catalogo-ventas.view', $this->getRenderData());
    }

    public function getRenderData()
    {
        $ventas = $this->getData()->paginate(50);

        $_ventas = $this->getData()->get();
        $totalVentas = $_ventas->sum('total');
        $totalVentasCanceladas = $_ventas->where('canceled_at', '!=', null)->sum('total');
        $totalVentasActivas = $_ventas->where('canceled_at', null)->sum('total');

        return [
            'ventas' => $ventas,
            'users' => User::orderBy('name')->get(),
            'total_ventas' => $totalVentas,
            'total_ventas_canceladas' => $totalVentasCanceladas,
            'total_ventas_activas' => $totalVentasActivas,
        ];
    }

    public function viewRegistros($id){
        $this->venta = Venta::findOrFail($id);
        $this->emit('showModal', '#mdlSaleDetails');
    }

    public function getData()
    {
        $ventas = Venta::orderBy('created_at', 'desc');
        $ventas->whereBetween('created_at', [$this->dateStart . ' 00:00:00', $this->dateEnd . ' 23:59:59']);

        if ($this->user_id) {
            $ventas->where('usuario_id', $this->user_id);
        }

        if ($this->keyWord) {
            $ventas->where(function ($query) {
                $query->where('id', $this->keyWord)
                ->orWhereHas('cliente', function ($query) {
                    $query->where('nombre', 'like', "%{$this->keyWord}%");
                });
            });
        }

        return $ventas;
    }

    public function exportToExcel()
    {
        $data = $this->getData()->get();

        $headers = [
            'ID',
            'Fecha',
            'Vendedor',
            'Cliente',
            'Monto Original',
            'Monto Venta',
        ];

        $arrayData = $data->map(function ($item) {
            return [
                $item->id_paddy,
                $item->fecha_creacion,
                $item->usuario->name,
                $item->cliente?->nombre ?? 'PUBLICO GENERAL',
                $item->total_actual,
                $item->total,
            ];
        });
        $reportDate = date('Y-m-d');
        $fileName = "ventas_{$reportDate}.csv";
        return DataExporter::downloadCSV($fileName, $headers, $arrayData);
    }

    public function cancelarVenta($id){
        $venta = Venta::findOrFail($id);
        $venta->cancelar();
        $this->emit('ok', 'Venta cancelada');
    }
}
