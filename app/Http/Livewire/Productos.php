<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\ClaveProducto;
use App\Models\ClaveUnidad;
use App\Models\Inventario;
use App\Models\MovimientoInventario;
use App\Models\Sucursal;
use App\Models\VentaRegistro;
use App\Models\VentaRegistroTemporal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Productos extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $activeTab = 1;
    
    // PRODUCT::
    public $id_product_selected;
    public $keyWord;
    public Producto $producto;

    // INVENTARIO::
    public $sucursalesInventario = [];
    public Inventario $inventario;

    //MOVIMIENTO DE INVENTARIO
    public MovimientoInventario $movimientoInventario;
    public $transferencia = false;

    public $catalogo_marcas;
    public $clave_productos;
    public $clave_unidades;

    public Marca $marca;
    public ClaveProducto $claveProducto;
    public ClaveUnidad $claveUnidad;

    public $sucursalActual;
    public $productCosto;
    public $productPrecio;
    public $productMinimo;
    public $productExistencia;


    public function mount()
    {
        $this->producto = new Producto();
        $this->inventario = new Inventario();
        $this->movimientoInventario = new MovimientoInventario();
        
        $this->catalogo_marcas = Marca::orderBy('nombre')->get();
        $this->clave_productos = ClaveProducto::all();
        $this->clave_unidades = ClaveUnidad::all();
        $this->sucursalActual = Sucursal::findOrfail(Auth::user()->sucursal_default)->nombre;    
    }

    protected $listeners = [
        'destroy' => 'destroy'
    ];

    protected $rules = [
        'producto.codigo' => 'string',
        'producto.descripcion' => 'string',
        'producto.unidad' => 'string',
        'producto.clave_producto_id' => 'numeric',
        'producto.clave_unidad_id' => 'numeric',
        'producto.marca' => 'string',
        'producto.categorias' => 'array',

        'inventario.sucursal_id' => 'integer',
        'inventario.producto_id' => 'integer',
        'inventario.minimo' => 'integer',
        'inventario.existencia' => 'integer',
        'inventario.costo' => 'numeric',
        'inventario.precio' => 'numeric',
        'inventario.activo' => 'boolean',

        'movimientoInventario.cantidad' => 'numeric',
        'movimientoInventario.comentarios' => 'string',
        'movimientoInventario.emisor_id' => 'numeric',
        'movimientoInventario.receptor_id' => 'numeric',

        'marca.nombre' => 'string',
        'claveProducto.clave' => 'string',
        'claveProducto.nombre' => 'string',
        'claveUnidad.clave' => 'string',
        'claveUnidad.nombre' => 'string',
    ];

    public function render(){
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.productos.view', [
            'productos' => Producto::latest()
            ->orWhere('codigo', 'LIKE', $keyWord)
            ->orWhere('descripcion', 'LIKE', $keyWord)
            ->orderBy('marca')
            ->orderBy('descripcion')
            ->paginate(50),
            'catalogo_categorias' => Categoria::orderBy('nombre')->get(),
            // 'clave_productos' => ClaveProducto::all(),
            // 'clave_unidades' => ClaveUnidad::all(),
        ]);
    }

    public function mdlNewProduct(){
        $this->resetInput();
        $this->emit('showModal', '#mdl');
    }

    public function toggle(){
        $this->showInventario($this->id_product_selected);
    }

    public function showInventario($prod){
        $this->activeTab = 1;
        $this->id_product_selected = $prod;
        $this->producto = Producto::findOrFail($this->id_product_selected);

        // $this->inventario = new Inventario(); // Reinicia el inventario que condiciona la vista de edicion en mdlInventario

        $this->sucursalesInventario = DB::table('sucursales')
        ->select('*', 'sucursales.id as sucursal_id')
        ->leftJoin('inventario', function($join){
            $join->on('sucursales.id', '=', 'inventario.sucursal_id');
            $join->on('inventario.producto_id', '=', DB::raw($this->id_product_selected));
        })->get();

        $this->emit('closeModal', '#mdlInventario');
        $this->emit('showModal', '#mdlInventarioSucursales');
    }

    public function editInventario($id_inv){

        $this->emit('closeModal', '#mdlInventarioSucursales');
        
        if($id_inv['id'] != null)
        {
            $this->inventario = Inventario::find($id_inv['id']);
        }
        else{
            $this->inventario = new Inventario([
                'minimo' => 0,
                'existencia' => 0,
                'costo' => 0.00,
                'precio' => 0.00,
                'sucursal_id' => $id_inv['sucursal_id'],
                'activo' => true,
                'producto_id' => $this->producto->id,
                ]
            );
        }

        $this->emit('showModal', '#mdlInventario');
        
    }

    public function saveInventario(){
        $this->validate([
            'inventario.sucursal_id' => 'required|int',
            'inventario.minimo' => 'required|int|min:0',
            'inventario.existencia' => 'required|int|min:0',
            'inventario.costo' => 'required|numeric',
            'inventario.precio' => 'required|numeric',
        ]);

        if($this->inventario->save()){
            $this->emit('ok', 'Se ha guardado Inventario');
            $this->showInventario($this->id_product_selected);
        }
    }

    public function cancel(){
        $this->resetInput();
    }
	
    private function resetInput(){
        $this->producto = new Producto();
        $this->inventario = new Inventario();
        $this->productCosto = null;
        $this->productPrecio = null;
        $this->productMinimo = null;
        $this->productExistencia = null;
        $this->emit('setMarca', array());
        $this->emit('setCategoria', array());
    }

    public function edit($id){
        $this->producto = Producto::findOrFail($id);
        $this->emit('setMarca', $this->producto->marca);
        $this->emit('setCategoria', json_decode($this->producto->categorias));
        $this->emit('showModal', '#mdl');
    }

    public function update(){

        $newProduct = !isset($this->producto->id);
        $validate = [
            'producto.codigo' =>'required|unique:productos,codigo,' . $this->producto->id . '|string',
            'producto.descripcion' =>'required|string',
            'producto.unidad' =>'required|string',
            'producto.clave_producto_id' =>'numeric|required',
            'producto.clave_unidad_id' =>'numeric|required',
            'producto.marca' =>'required|string',
        ];
        
        if($newProduct){
            $validate['productCosto'] = 'required|numeric|min:0';
            $validate['productPrecio'] = 'required|numeric|min:0';
            $validate['productMinimo'] = 'required|numeric|min:0';
            $validate['productExistencia'] = 'required|numeric|min:0';
        }
        
        if($this->producto->categorias == null){
            $this->producto->categorias = "[]";
        }

        $this->validate($validate);

        if($this->producto->save()){

            if($newProduct){
                Inventario::create([
                    'sucursal_id' => Auth::user()->sucursal_default,
                    'producto_id' => $this->producto->id,
                    'minimo' => $this->productMinimo,
                    'existencia' => $this->productExistencia,
                    'costo' => $this->productCosto,
                    'precio' => $this->productPrecio,
                    'activo' => true,
                ]);

                if($this->productExistencia > 0){
                    MovimientoInventario::create([
                        'tipo' => 'INICIAL',
                        'cantidad' => $this->productExistencia,
                        'comentarios' => 'Inventario Inicial',
                        'receptor_id' => Auth::user()->sucursal_default,
                        'usuario_id' => Auth::user()->id,
                        'producto_id' => $this->producto->id,
                    ]);
                }
            }

            $this->emit('closeModal');
            $this->emit('ok', 'Se ha guardado Producto: ' . strtoupper($this->producto->descripcion));
            $this->resetInput();
        }
    }

    public function destroy($id){
        if ($id) {
            $prod = Producto::where('id', $id)->first();
            foreach ($prod->inventarios as $inv) {
                $inv->delete();
            }
            foreach ($prod->movimientos_inventario as $mov) {
                $mov->delete();
            }
            VentaRegistro::where('producto_id', $id)->update(['producto_id' => null]);
            VentaRegistroTemporal::where('producto_id', $id)->delete();
            if($prod->delete()){
                $this->emit('ok', 'Se ha eliminado Producto: ' . strtoupper($prod->descripcion));
            }
        }
    }

    public function showMdlIO($entrada){
        $this->transferencia = false;
        $this->movimientoInventario = new MovimientoInventario();
        $this->movimientoInventario->cantidad = 0;
        if($entrada){
            $this->movimientoInventario->receptor_id = $this->inventario->sucursal_id;
        } else {
            $this->movimientoInventario->emisor_id = $this->inventario->sucursal_id;
        }
        $this->emit('showModal', '#mdlIO');
    }

    public function cbTransferChange(){
        if(!$this->transferencia){
            $this->movimientoInventario->receptor_id = 0;
        }
    }

    public function saveIO(){
        $receiptValidate = 'integer|nullable';
        if($this->transferencia){
            $receiptValidate = 'integer|min:1';
        }
        else if($this->movimientoInventario->receptor_id == 0){
            $this->movimientoInventario->receptor_id = null;
        }

        $this->validate([
            'movimientoInventario.cantidad' => 'numeric|min:1',
            'movimientoInventario.comentarios' => 'string|min:10',
            'movimientoInventario.receptor_id' => $receiptValidate,
        ],[
            'integer' => 'Seleccione sucursal receptora'
        ]);
        
        if($this->movimientoInventario->receptor_id == $this->inventario->sucursal_id)
        {
            $this->inventario->existencia += $this->movimientoInventario->cantidad;
        }
        else{

            $disponible_salida = $this->inventario->qty_disponible();
            if($disponible_salida < $this->movimientoInventario->cantidad){
                if($disponible_salida){
                    $this->emit('info', 'Solamente existen ' . $disponible_salida . ' unidades disponibles', 'Cantidad NO disponible');
                }
                else{
                    $this->emit('info', 'No existen unidades disponibles', 'Sin Inventario');
                }
                
                return;
            }

            $this->inventario->existencia -= $this->movimientoInventario->cantidad;
            if($this->movimientoInventario->receptor_id){
                $suc_receptora = $this->producto->inventarios->where('sucursal_id', $this->movimientoInventario->receptor_id)->first();
                if($suc_receptora == null){
                    $suc_receptora = new Inventario(['minimo' => 0, 'costo' => 0, 'precio' => 0]);
                    $suc_receptora->sucursal_id = $this->movimientoInventario->receptor_id;
                }
                $suc_receptora->existencia += $this->movimientoInventario->cantidad;
                $suc_receptora->save();
            }
        }

        
        if($this->inventario->save())
        {
            $this->movimientoInventario->usuario_id = Auth::user()->id;
            $this->movimientoInventario->tipo = $this->transferencia ? 'TRANSFERENCIA' : 'MANUAL';
            $this->movimientoInventario->producto_id = $this->producto->id;
    
            if($this->movimientoInventario->save()){
                $this->movimientoInventario = new MovimientoInventario();
                $this->emit('ok', 'Se ha registrado Movimiento de Inventario');
                $this->emit('closeModal', '#mdlIO');
            }
        }


    }

    public function mdlMarca(){
        $this->marca = new Marca();
        $this->emit('showModal', '#mdlMarca');
    }

    public function mdlClaveProducto(){
        $this->claveProducto = new ClaveProducto();
        $this->emit('showModal', '#mdlClaveProducto');
    }

    public function mdlClaveUnidad(){
        $this->claveUnidad = new ClaveUnidad();
        $this->emit('showModal', '#mdlClaveUnidad');
    }

    public function saveMarca(){
        $this->validate([
            'marca.nombre' => 'string|required|unique:marcas,nombre',
        ]);

        $nombre = $this->marca->nombre;
        if($this->marca->save()){
            $this->emit('closeModal', '#mdlMarca');
            $this->emit('ok', "Se ha agregado Marca: {$this->marca->nombre}");
            $this->emit('addMarca', $this->marca->nombre);
        }
    }

    public function saveClaveProducto(){
        $this->validate([
            'claveProducto.clave' => 'string|required|unique:clave_productos,clave',
            'claveProducto.nombre' => 'string|required',
        ]);

        $nombre = $this->claveProducto->nombre;
        if($this->claveProducto->save()){
            $this->emit('closeModal', '#mdlClaveProducto');
            $this->emit('ok', "Se ha agregado Clave: {$nombre}");
            $this->clave_productos->push($this->claveProducto);
            $this->producto->clave_producto_id = $this->claveProducto->id;
        }
    }

    public function saveClaveUnidad(){
        $this->validate([
            'claveUnidad.clave' => 'string|required|unique:clave_unidades,clave',
            'claveUnidad.nombre' => 'string|required',
        ]);

        $nombre = $this->claveUnidad->nombre;
        if($this->claveUnidad->save()){
            $this->emit('closeModal', '#mdlClaveUnidad');
            $this->emit('ok', "Se ha agregado Clave: {$nombre}");
            $this->clave_unidades->push($this->claveUnidad);
            $this->producto->clave_unidad_id = $this->claveUnidad->id;
        }
    }
}
