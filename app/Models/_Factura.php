<?php

namespace App\Models;

use App\Http\Controllers\FacturaController;
use App\Mail\FacturaMailable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Exception;
use Illuminate\Support\Facades\Mail;
use stdClass;

class Factura extends BaseModel
{
    use HasFactory;

    protected $table = 'facturas';

    protected $fillable = [
        'usuario_id',
        'sucursal_id',
        'emisor_id',
        'entidad_fiscal_id',
        'model_id',
        'model_type',
        'tipo',
        'forma_pago',
        'serie',
        'folio',
        'tasa_iva',
        'subtotal',
        'total',
        'uuid',
        'xml',
        'estatus',
        'comentarios',
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }
    
    public function emisor(){
        return $this->belongsTo(Emisor::class, 'emisor_id');
    }

    public function entidad_fiscal(){
        return $this->belongsTo(EntidadFiscal::class, 'entidad_fiscal_id');
    }

    public function model(){
        return $this->morphTo();
    }

    public function complementos(){
        return $this->belongsToMany(Complemento::class);
    }

    public function getNoFacturaAttribute(){
        return "{$this->serie}{$this->folio}";
    }

    public function sendMail(SendMail $mail){
        try{
            $mailable = new FacturaMailable($mail->model);
            Mail::to(json_decode($mail->to))->send($mailable);
            $mail->sent = now();
            $mail->save();
        }
        catch(Exception $e){
            ErrorLog::create(['titulo' => 'EnviarCorreo', 'error' => $e->getMessage()]);
        }
    }

    public function mailAttach(){
        $attch = new stdClass();
        $attch->file = FacturaController::factura_pdf($this);
        $attch->file_name = "Factura_{$this->factura->id}.pdf";
        $attch->options = [];

        $attch2 = new stdClass();
        $attch2->file = $this->xml;
        $attch2->file_name = "Factura_{$this->factura->id}.xml";
        $attch2->options = ['mime' => 'text/xml'];

        return [
            $attch,
            $attch2
        ];
    }
}
