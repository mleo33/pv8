<?php

namespace App\Mail;

use App\Http\Controllers\ComplementoController;
use App\Models\Complemento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplementoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public Complemento $complemento;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Complemento $complemento)
    {
        $this->subject = $_ENV['APP_FULL_NAME'] . $this->subject;
        $this->complemento = $complemento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file = ComplementoController::complemento_pago_pdf($this->complemento); //DEUDA
        $fileNamePDF = 'Complemento_' . $this->complemento->id . '.pdf';
        $fileNameXML = 'Complemento_' . $this->complemento->id . '.xml';
        $email = $this->view('emails.ComplementoMail');
        $email->attachData($file, $fileNamePDF);
        $email->attachData($this->complemento->xml, $fileNameXML,[
            'mime' => 'text/xml'
        ]);

        return $email;
    }
}
