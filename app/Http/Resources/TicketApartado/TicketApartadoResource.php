<?php

namespace App\Http\Resources\TicketApartado;

use App\Http\Resources\TicketVenta\TicketConceptoResource;
use App\Http\Resources\TicketVenta\TicketSucursalResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketApartadoResource extends JsonResource
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
            'conceptos' => TicketConceptoResource::collection($this->conceptos),
            'ingresos' => $this->ingresos,
            'fecha' => Carbon::parse($this->created_at)->translatedFormat('F/d/Y h:i A'),
            'subtotal' => $this->subtotal,
            'iva' => $this->iva,
            'total' => $this->total,
            'vence' => ucfirst(Carbon::parse($this->vence)->translatedFormat('F/d/Y')),
        ];
    }
}
