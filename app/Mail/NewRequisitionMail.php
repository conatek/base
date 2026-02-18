<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\CollaboratorRequisition;

class NewRequisitionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $requisition;
    public $title;
    public $action;
    public $status_comment;

    public function __construct(CollaboratorRequisition $requisition, string $action, ?string $status_comment = null)
    {
        $this->requisition = $requisition;
        $this->action = $action;
        $this->status_comment = $status_comment;

        // Definir el título aquí
        $this->title = match($action) {
            'create'  => 'Nueva Requisición',
            'update'  => 'Requisición Actualizada',
            'approve' => 'Requisición Aprobada',
            'cancel'  => 'Requisición Cancelada',
            default   => 'Notificación de Requisición'
        };
    }

    public function build()
    {
        $positionName = $this->requisition->position->name ?? 'Cargo';
        $areaName = $this->requisition->area->name ?? 'Área';

        return $this->subject("{$this->title}: {$positionName} - {$areaName}")
                    ->view('emails.new-requisition');
    }
}
