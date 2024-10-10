<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Illuminate\Support\Facades\DB;

class Inventario extends BaseModel
{
	use HasFactory;


    protected $table = 'inventario';

    protected $fillable = [
        'producto_id',
        'sucursal_id',
        'minimo',
        'existencia',
        'costo',
        'precio',
        'activo',
    ];

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function qty_disponible(){
        $temporales = DB::table('venta_registros_temporales')
        ->join('ventas_temporales', 'ventas_temporales.id', '=', 'venta_registros_temporales.venta_temporal_id')
        ->where(['ventas_temporales.sucursal_id' => $this->sucursal_id, 'venta_registros_temporales.producto_id' => $this->producto_id])
        ->get()->sum('cantidad');

        $apartados = DB::table('apartado_conceptos')
        ->join('apartados', 'apartados.id', '=', 'apartado_conceptos.apartado_id')
        ->where(['apartados.sucursal_id' => $this->sucursal_id, 'apartado_conceptos.producto_id' => $this->producto_id])
        ->where('apartados.venta_id', null)
        ->where('apartados.vence', '>=', now())
        ->get()->sum('cantidad');

        return $this->existencia - $temporales - $apartados;
    }

    public function otras_sucursales(){
        return Sucursal::where('id', '!=', $this->sucursal_id)->get();
    }

    public function entradas(){
        return MovimientoInventario::orderBy('id','desc')->where(['producto_id' => $this->producto_id, 'receptor_id' => $this->sucursal_id])->paginate(30, ['*'], 'pageEntradas');
    }

    public function salidas(){
        return MovimientoInventario::orderBy('id','desc')->where(['producto_id' => $this->producto_id, 'emisor_id' => $this->sucursal_id])->paginate(30, ['*'], 'pageSalidas');
    }

    public function apartados(){
        return Apartado::orderBy('created_at','desc')
        ->where('sucursal_id', $this->sucursal_id)
        ->where('vence', '>=', now())
        ->where('venta_id', null)
        ->whereHas('conceptos', function($q){
            $q->where('producto_id', $this->producto_id);
        })->get();
    }

    
}
