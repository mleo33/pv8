<?php

namespace App\Http\Livewire\Devolucion\Common;

use App\Classes\Constants;
use App\Models\Devolucion;
use App\Models\Ingreso;
use App\Models\MovimientoInventario;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaRegistro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class BtnDevolucion extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $formas_pago_venta = Constants::FORMAS_PAGO_VENTA;
    public $formas_pago;

    public $keyWord;
    public $cantidadDevolucion = 0;
    public $modalName;
    public $modalPayment;
    public $concepto;
    public $selectedProducts;

    protected function rules()
    {
        return [
            'selectedProducts.*.selected' => 'numeric|required',
            'selectedProducts.*.cantidad' => 'numeric|required|min:1',
            'cantidadDevolucion' => "numeric|required|min:1|max:{$this->concepto->cantidad}",
        ];
    }

    public function updatingKeyWord()
    {
        $this->resetPage('prodDevPage');
    }

    public function updatedCantidadDevolucion($value)
    {
        if(!is_numeric($value)){
            $this->cantidadDevolucion = 1;
        }
    }

    public function mount($concepto){
        $this->concepto = $concepto;
        $this->modalName = 'mdlDevolucion' . uniqid();
        $this->modalPayment = 'payment' . $this->modalName;

        $this->formas_pago = Collect([array('forma' => 'EFECTIVO', 'monto' => 0)]);
    }

    public function render()
    {
        return view('livewire.devolucion.common.btn-devolucion',[
            'productos' => Producto::orderBy('descripcion', 'desc')
            ->orWhere('descripcion', 'LIKE', '%' . $this->keyWord . '%')
            ->paginate(20, ['*'], 'prodDevPage'),
        ]);
    }

    public function formasPagoRestantes(){
        return collect($this->formas_pago_venta)->diff($this->formas_pago->pluck('forma'))->all();
    }

    public function removeFormaPago($index)
    {
        $this->formas_pago->splice($index, 1);
    }

    public function addFormaPago()
    {
        if (count($this->formasPagoRestantes()) > 0) {
            $this->formas_pago->push([
                'forma' => collect($this->formasPagoRestantes())->first(),
                'monto' => 0,
            ]);
            // $this->changeFormaPago();
            // $this->formas_pago_restantes = $this->formas_pago_restantes;

        }
    }

    public function showBtnDevolucion(){
        return (
            collect($this->selectedProducts)->where('selected', true)
            ->where('cantidad', '>', 0)->count()
            && $this->cantidadDevolucion > 0
        );
    }

    public function importeSeleccionado(){
        return collect($this->selectedProducts)
        ->where('selected', true)
        ->map(function($item, $index){
        $cant = $this->selectedProducts[$index]['selected'] ?? 0;
        $precio = $this->selectedProducts[$index]['cantidad'] ?? 0;
        return [ 'total' =>  floatval($cant) * floatval($precio)];
        })->sum('total');
    }

    public function importeDevolucion(){
        return ($this->cantidadDevolucion * $this->concepto->precio);
    }

    public function diferenciaAPagar(){
        $diferencia = $this->importeSeleccionado() - $this->importeDevolucion();
        return $diferencia;
    }

    public function generarDevolucion(){

        $products = collect($this->selectedProducts);
        $this->selectedProducts = $products->reject(function($item){
            return !$item['selected'];
        });

        $this->validate();



        if($this->diferenciaAPagar() > 0){
            $this->emit('closeModal', "#{$this->modalName}");
            $this->emit('showModal', "#{$this->modalPayment}");
            return;
        }
        $this->createDevolucion();
    }

    public function createDevolucion(){
        $devolucion = Devolucion::create([
            'venta_id' => $this->concepto->venta_id,
            'venta_registro_id' => $this->concepto->id,
            'codigo' => $this->concepto->codigo,
            'descripcion' => $this->concepto->descripcion,
            'cantidad' => $this->cantidadDevolucion,
            'precio' => $this->concepto->precio,
        ]);

        // $venta_reg = VentaRegistro::findOrFail($this->concepto->id);

        $inv = $this->concepto->producto->inventario_actual();
        $inv->existencia += $this->cantidadDevolucion;
        
        if($inv->save()){
            MovimientoInventario::create([
                'usuario_id' => Auth::user()->id,
                'tipo' => 'DEVOLUCION',
                'producto_id' => $this->concepto->product_id,
                'receptor_id' => $devolucion->sucursal_id,
                'cantidad' => $this->cantidadDevolucion,
                'comentarios' => 'Devolución Venta #' . str_pad($this->concepto->venta_id, 4, '0', STR_PAD_LEFT),
            ]);
        }

        $this->concepto->cantidad = $this->concepto->cantidad -  $this->cantidadDevolucion;
        $this->concepto->save();

        $products = collect($this->selectedProducts);
        foreach ($products as $key => $value) {
            $product = Producto::findOrFail($key);
            $registro = VentaRegistro::create([
                'venta_id' => $this->concepto->venta_id,
                'producto_id' => $product->id,
                'codigo' => $product->codigo,
                'descripcion' => $product->descripcion,
                'cantidad' => $value['cantidad'],
                'precio' => $value['selected'],
            ]);

            $inventario = $product->inventario_actual();
            $inventario->existencia -= $value['cantidad'];
            if($inventario->save())
            {
                MovimientoInventario::create([
                    'usuario_id' => Auth::user()->id,
                    'tipo' => 'CAMBIO',
                    'producto_id' => $product->id,
                    'emisor_id' => $devolucion->sucursal_id,
                    'cantidad' => $value['cantidad'],
                    'comentarios' => 'Cambio Venta #' . str_pad($this->concepto->venta_id, 4, '0', STR_PAD_LEFT),
                ]);
            }

            DB::insert('INSERT INTO devolucion_cambios (devolucion_id, venta_registro_id) VALUES (?, ?)', [$devolucion->id, $registro->id]);
        }

        if($this->diferenciaAPagar() > 0){
            $pagosCount = $this->formas_pago->count();
            foreach($this->formas_pago as $ing)
            {
                $monto = $pagosCount == 1 ? $this->diferenciaAPagar() : $ing['monto'];
                $pago = $ing['monto'];
                $cambio = floatval($pago) - floatval($monto);

                Ingreso::create([
                    'tipo' => 'PAGO',
                    'forma_pago' => $ing['forma'],
                    'monto' => $monto,
                    'referencia' => '',
                    'model_type' => Venta::class,
                    'model_id' => $this->concepto->venta_id,
                    'pago' => $pago,
                    'cambio' => $cambio,
                ]);
            }
        }

        $this->emit('closeModal', "#{$this->modalName}");
        $this->emit('closeModal', "#{$this->modalPayment}");
        $this->emit('ok', 'Se ha generado devolución');
    }
}
