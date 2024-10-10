<?php

namespace App\Mail;

use App\Http\Controllers\PdfController;
use App\Models\Factura;
use App\Models\FacturaTemporal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FacturaMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = ": Envio de Factura (CFDI)";
    public Factura $factura;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Factura $factura)
    {
        $this->subject = $_ENV['APP_FULL_NAME'] . $this->subject;
        $this->factura = $factura;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file = PdfController::factura_pdf($this->factura); //DEUDA
        $fileNamePDF = 'Factura_' . $this->factura->id . '.pdf';
        $fileNameXML = 'Factura_' . $this->factura->id . '.xml';
        $email = $this->view('emails.FacturaMail');
        $email->attachData($file, $fileNamePDF);
        $email->attachData($this->factura->xml, $fileNameXML,[
            'mime' => 'text/xml'
        ]);

        return $email;
    }
}
