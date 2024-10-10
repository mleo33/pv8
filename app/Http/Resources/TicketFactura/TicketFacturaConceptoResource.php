<?php

namespace App\Http\Resources\TicketFactura;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketFacturaConceptoResource extends JsonResource
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
            "ClaveProdServ" => strval($this['ClaveProdServ']),
            "Descripcion" => strval($this['Descripcion']),
            "ClaveUnidad" => strval($this['ClaveUnidad']),
            "Cantidad" => strval($this['Cantidad']),
            "ValorUnitario" => strval($this['ValorUnitario']),
            "Importe" => strval($this['Importe']),
        ];
    }
}
