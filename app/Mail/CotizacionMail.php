<?php

namespace App\Mail;

use App\Http\Controllers\PdfController;
use App\Models\Cotizacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CotizacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public Cotizacion $cotizacion;
    public $textMessage;

    public function __construct(Cotizacion $cotizacion, $textMessage)
    {
        $this->cotizacion = $cotizacion;
        $this->textMessage = $textMessage;
        $this->subject = $_ENV['APP_FULL_NAME'] . ": Pedido #" . $cotizacion->id_paddy;
    }

    public function build()
    {
        $file = PdfController::cotizacion_pdf($this->cotizacion);
        $fileNamePDF = 'Pedido_' . $this->cotizacion->id_paddy . '.pdf';
        $email = $this->view('emails.CotizacionMail');
        $email->attachData($file, $fileNamePDF);
        return $email;
    }
}
