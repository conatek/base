<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IndividualCollaboratorReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pdfContent;
    public $excelContent; // Nueva propiedad
    public $collaborator;

    public function __construct($user, $collaborator, $pdfContent, $excelContent)
    {
        $this->user = $user;
        $this->collaborator = $collaborator;
        $this->pdfContent = $pdfContent;
        $this->excelContent = $excelContent;
    }

    public function build()
    {
        $fileName = 'reporte-' . str_replace(' ', '-', mb_strtolower($this->collaborator->name, 'UTF-8'));
        
        return $this->subject("Reporte Detallado: {$this->collaborator->name}")
            ->view('emails.individual-collaborator-report')
            ->attachData($this->pdfContent, "{$fileName}.pdf", ['mime' => 'application/pdf'])
            ->attachData($this->excelContent, "{$fileName}.xlsx", [
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }
}
