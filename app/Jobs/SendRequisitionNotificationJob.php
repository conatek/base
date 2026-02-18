<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\NewRequisitionMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Models\CollaboratorRequisition;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendRequisitionNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $requisition;
    protected $action;
    protected $comment;

    /**
     * @param CollaboratorRequisition $requisition
     * @param string $action 'create' | 'update' | 'approve' | 'cancel'
     * @param string|null $comment Comentario opcional (motivo cancelación/aprobación)
     */
    public function __construct(CollaboratorRequisition $requisition, string $action = 'create', ?string $comment = null)
    {
        $this->requisition = $requisition;
        $this->action = $action;
        $this->comment = $comment;
    }

    public function handle()
    {
        // 1. Cargar relaciones
        $this->requisition->load([
            'position', 'area', 'requisition_type',
            'vacancy_reason', 'vacancy_status',
            'replaces', 'requested_by'
        ]);

        $finalEmails = [];

        $staffEmails = User::where('company_id', $this->requisition->company_id)
            // ->where('is_active', 1)
            ->role([3, 4, 7]) // 3: Admin, 4: Analyst, 7: Approver
            ->pluck('email')
            ->toArray();

        $requesterEmail = null;
        if ($this->requisition->requested_by && $this->requisition->requested_by->user) {
            $requesterEmail = $this->requisition->requested_by->user->email;
        }

        $allRecipients = array_merge($staffEmails, [$requesterEmail]);
        $finalEmails = array_unique(array_filter($allRecipients));

        if (!empty($finalEmails)) {
            Mail::to($finalEmails)->send(new NewRequisitionMail(
                $this->requisition,
                $this->action,
                $this->comment
            ));
        }
    }
}
