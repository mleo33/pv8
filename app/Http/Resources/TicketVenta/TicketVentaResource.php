<?php

namespace App\Http\Resources\TicketVenta;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketVentaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sucursal' => $this->sucursal,
            'cliente' => $this->cliente,
            'sucursal' => new TicketSucursalResource($this->sucursal),
            'conceptos' => TicketConceptoResource::collection($this->registros),
            'ingresos' => $this->ingresos,
            'fecha' => Carbon::parse($this->created_at)->format('M/d/Y h:i A'),
            'subtotal' => $this->subtotal,
            'iva' => $this->iva,
            'total' => $this->total,
            'pagado' => $this->pagado,
            'saldo' => $this->saldo,
            'tasa_iva' => $this->tasa_iva,
        ];
    }
}
