<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\CollaboratorRequisition;

class RequisitionStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $requisition;
    public $title;
    public $action; // 'create', 'update', 'approve', 'cancel'
    public $status_comment; // Motivo de rechazo o aprobación

    public function __construct(CollaboratorRequisition $requisition, string $action, ?string $status_comment = null)
    {
        $this->requisition = $requisition;
        $this->action = $action;
        $this->status_comment = $status_comment;

        // Definir título según acción
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
                    ->view('emails.new-requisition'); // Usamos la misma vista
    }
}
