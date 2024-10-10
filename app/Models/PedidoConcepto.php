<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PedidoConcepto extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'codigo',
        'descripcion',
        'cantidad',
        'cantidad_recibida',
        'precio',
    ];

    public function pedido(){
        return $this->belongsTo(Pedido::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function getImporteAttribute(){
        try{
            return $this->cantidad * $this->precio;
        }
        catch (Exception $e){
            return 0;
        }
    }

    public function getPendienteRecibirAttribute(){
        return $this->cantidad - $this->cantidad_recibida;
    }

    public function recibirProducto($cantidad){
        
        $inventario = $this->producto->current_inventory;
        
        if($inventario === null){
            $user = Auth::user();

            $inventario = new Inventario();
            $inventario->producto_id = $this->producto_id;
            $inventario->sucursal_id = $user->sucursal_default;
            $inventario->minimo = 0;
            $inventario->existencia = 0;
            $inventario->costo = $this->precio;
            $inventario->precio = 0;
            $inventario->activo = 1;
        }

        $inventario->existencia += $cantidad;

        if($inventario->save()){
            
            $this->cantidad_recibida += $cantidad;
            $this->save();

            MovimientoInventario::create([
                'usuario_id' => Auth::user()->id,
                'tipo' => 'PEDIDO',
                'producto_id' => $this->producto_id,
                'receptor_id' => $this->pedido->sucursal_id,
                'cantidad' => $cantidad,
                'comentarios' => 'Pedido #' . str_pad($this->pedido_id, 4, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
