<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;

class Emisor extends BaseModel
{
    use HasFactory;

    protected $table = 'emisores';

    protected $fillable = [
        'nombre',
        'rfc',
        'regimen_fiscal',
        'lugar_expedicion',
        'serie',
        'serie_complementos',
        'folio_facturas',
        'folio_complementos',
        'no_certificado',
        'clave_certificado',
        'fd_user',
        'fd_pass',
        'cer',
        'key',
        'pem',
        'pfx',
    ];

    //cer -> Certificado archivo .cer
    //key -> archivo key.pem
    //pem -> **sin uso**
    //pfx -> pkcs12 Archivo.pfx en base64

    public function setNombreAttribute($value){
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function setRfcAttribute($value){
        $this->attributes['rfc'] = strtoupper($value);
    }

    public function setSerieAttribute($value){
        $this->attributes['serie'] = strtoupper($value);
    }

    public function setSerieComplementosAttribute($value){
        $this->attributes['serie_complementos'] = strtoupper($value);
    }
    
    public function sucursales(){
        return $this->hasMany(Sucursal::class);
    }
}
