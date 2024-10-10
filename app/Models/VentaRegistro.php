<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Productos;

class VentaRegistro extends BaseModel
{
    use HasFactory;

    protected $table = 'venta_registros';

    protected $fillable = [
        'venta_id',
        'producto_id',
        'codigo',
        'descripcion',
        'cantidad',
        'precio',
    ];

    public function importe(){
        return $this->cantidad * $this->precio;
    }

    public function getImporteAttribute(){
        return $this->cantidad * $this->precio;
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function getDiasTranscurridosAttribute(){
        return Carbon::parse($this->created_at)->diffInDays(Carbon::now());
    }

    public function getCanReturnAttribute(){
        return $this->dias_transcurridos <= 8;
    }

    public function getFactorIvaAttribute(){
        return $this->venta->tasa_iva / 100;
    }

    public function getImporteSIvaAttribute(){
        return round($this->importe / (1 + $this->factor_iva), 2);
    }

    public function getIvaAttribute(){
        return round($this->total - $this->subtotal, 2);
    }

    public function getSubtotalAttribute(){
        return round($this->total / (1 + $this->factor_iva), 2);
    }

    public function getTotalAttribute(){
        return $this->cantidad * $this->precio;
    }

    public function cancel(){
        if($this->producto && $this->venta->canceled_at == null){
            Inventario::where(['producto_id' => $this->producto_id, 'sucursal_id' => $this->venta->sucursal_id])
            ->update([
                'existencia' => DB::raw('existencia + ' . $this->cantidad)
            ]);

            MovimientoInventario::create([
                'usuario_id' => Auth::id(),
                'tipo' => 'CANCELACION',
                'producto_id' => $this->producto_id,
                'receptor_id' => $this->venta->sucursal_id,
                'cantidad' => $this->cantidad,
                'comentarios' => 'Cancelación de venta #' . $this->venta->id_paddy
            ]);
        }
    }
    


}
