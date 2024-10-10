<?php

namespace App\Http\Resources\TicketVenta;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketEmisorResource extends JsonResource
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
            'nombre' => $this->nombre,
            'rfc' => $this->rfc,
            'regimen_fiscal' => $this->regimen_fiscal,
            'lugar_expedicion' => $this->lugar_expedicion,
        ];
    }
}
