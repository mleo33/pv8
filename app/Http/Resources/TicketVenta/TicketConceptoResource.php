<?php

namespace App\Http\Resources\TicketVenta;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketConceptoResource extends JsonResource
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
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'cantidad' => $this->cantidad,
            'precio' => floatval($this->precio),
            'subtotal' => floatval($this->subtotal),
            'iva' => floatval($this->iva),
            'total' => floatval($this->total),
        ];
    }
}
