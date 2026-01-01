<?php

namespace App\Jobs;

use App\Models\Collaborator;
use Illuminate\Bus\Queueable;
use Spatie\Browsershot\Browsershot;
use App\Mail\CollaboratorReportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Exports\CollaboratorsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendCollaboratorReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $company = $this->user->company;

        // Tu lógica de consulta (copiada del controlador)
        $collaborators = Collaborator::where('is_active', 1)
            ->whereHas('activeContract')
            ->with([
                'document_type',
                'document_province',
                'document_city',
                'birth_province',
                'birth_city',
                'housing_tenure',
                'stratum_type',
                'civil_status_type',
                'highest_academic_achievement.achievement_type',
                'sex_type',
                'rh_type',
                'staff_provider',
                'social_security.eps',
                'social_security.afp_pension',
                'social_security.afp_saving',
                'social_security.arl',
                'social_security.ccf',
                'bank_account.bank',
                'bank_account.accountType',

                'activeContract.position.area',
                'activeContract.position.area.campus',
                'activeContract.position.area.leader',
                'activeContract.position.position_criticality_level',
                'activeContract.position.position_risk_class',
                'activeContract.contractType',

                // 'activeContract.bank'
                'families.relationship', 
                'families.occupation',
                'families.sex_type',
                'academic_achievements.achievement_type',
                'medical_examinations.examination_type',
                'home_visits.home_visit_type'
            ])
            ->where('company_id', $this->user->company_id)
            ->orderBy('name')
            ->get();

        $html = View::make('pdf.collaborators-report', compact('company', 'collaborators'))->render();

        $pdf = Browsershot::html($html)
            ->format('Letter')
            ->margins(10, 10, 10, 10)
            ->noSandbox()
            ->waitUntilNetworkIdle()
            ->pdf();

        $excel = Excel::raw(new CollaboratorsExport($collaborators), \Maatwebsite\Excel\Excel::XLSX);

        // Enviar el correo
        Mail::to($this->user->email)->send(new CollaboratorReportMail($this->user, $pdf, $excel));
    }
}