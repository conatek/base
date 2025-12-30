<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CollaboratorReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pdfContent;
    public $excelContent; // Nueva propiedad

    public function __construct($user, $pdfContent, $excelContent)
    {
        $this->user = $user;
        $this->pdfContent = $pdfContent;
        $this->excelContent = $excelContent;
    }

    public function build()
    {
        return $this->subject('Tus Reportes de Colaboradores están listos')
            ->view('emails.collaborators-report')
            ->attachData($this->pdfContent, 'reporte-colaboradores.pdf', [
                'mime' => 'application/pdf',
            ])
            ->attachData($this->excelContent, 'reporte-colaboradores.xlsx', [
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }
}
