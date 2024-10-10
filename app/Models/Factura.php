<?php

namespace App\Models;

use App\Classes\FacturacionConstants;
use App\Events\FacturaCreated;
use App\Http\Controllers\FacturaController;
use App\Mail\FacturaMailable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\shared\BaseModel;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            // FacturaCreated::dispatch($model);
        });
    }

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

    public function createPDF(){
        $factura = $this;
        $cfdi = FacturaController::getXmlToPDFResource($factura);        
        $pdf = PDF::loadView('pdf.facturacion.factura_pdf', ['cfdi' => collect($cfdi)]);
        $pdf->setPaper('A4');
        return $pdf;
    }

    public function createAndSavePDF(){
        $pdf = $this->createPDF();
        Storage::disk('public')->put("facturas/{$this->uuid}.pdf", $pdf->output());
    }

    public function createAndOpenPDF(){
        $pdf = $this->createPDF();
        $pdf->setPaper('A4');
        
        return $pdf->stream($this->uuid . '.pdf');
    }

    public function fecha_format_reporte(){
        return Carbon::parse($this->created_at)->format('m/d/y h:i A');
    }
}
