<?php

namespace App\Http\Resources\TicketVenta;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketSucursalResource extends JsonResource
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
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'mensaje_ticket_venta' => $this->mensaje_ticket_venta,
            'mensaje_ticket_renta' => $this->creatmensaje_ticket_rentaed_at,
            'tasa_iva' => $this->tasa_iva,
            'emisor' => new TicketEmisorResource($this->emisor),
        ];
    }
}
