<?php

namespace App\Mail;

use App\Http\Controllers\PdfController;
use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoMail extends Mailable
{
    use Queueable, SerializesModels;

    public Pedido $pedido;
    public $textMessage;

    public function __construct(Pedido $pedido, $textMessage)
    {
        $this->pedido = $pedido;
        $this->textMessage = $textMessage;
        $this->subject = $_ENV['APP_FULL_NAME'] . ": Pedido #" . $pedido->id_paddy;
    }

    public function build()
    {
        $file = PdfController::pedido_pdf($this->pedido);
        $fileNamePDF = 'Pedido_' . $this->pedido->id_paddy . '.pdf';
        $email = $this->view('emails.PedidoMail');
        $email->attachData($file, $fileNamePDF);
        return $email;

    }
}
