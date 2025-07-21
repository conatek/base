<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CollaboratorUploadErrorsMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function build()
    {
        return $this->subject('Errores en la carga de colaboradores')
            ->view('emails.collaborator.errors')
            ->attach(storage_path("app/public/upload-collaborators/errors/{$this->filename}"));
    }
}
