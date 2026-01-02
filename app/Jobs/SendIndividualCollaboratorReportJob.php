<?php

namespace App\Jobs;

use App\Models\Collaborator;
use App\Mail\IndividualCollaboratorReportMail;
use App\Exports\CollaboratorsExport; // Reutilizamos o creamos uno nuevo
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\{Mail, View, Auth};
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class SendIndividualCollaboratorReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $collaborator;

    public function __construct($user, $collaborator)
    {
        $this->user = $user;
        $this->collaborator = $collaborator;
    }

    public function handle()
    {
        $company = $this->user->company;
        
        // Cargamos el colaborador con TODAS sus relaciones
        $collab = Collaborator::with([
            'document_type', 'document_province', 'document_city', 
            'birth_province', 'birth_city', 'residence_province', 'residence_city',
            'housing_tenure', 'stratum_type', 'civil_status_type', 'sex_type', 'rh_type',
            'staff_provider', 'social_security.eps', 'social_security.arl', 
            'social_security.afp_pension', 'social_security.afp_saving', 'social_security.ccf',
            'bank_account.bank', 'bank_account.accountType',
            'activeContract.position.area.campus', 'activeContract.contractType',
            'families.relationship', 'academic_achievements.achievement_type',
            'medical_examinations.examination_type', 'home_visits.home_visit_type'
        ])->find($this->collaborator->id);

        // 1. Generar PDF
        $html = View::make('pdf.individual-collaborator-report', compact('company', 'collab'))->render();
        $pdf = Browsershot::html($html)
            ->format('Letter')
            ->margins(10, 10, 10, 10)
            ->noSandbox()
            ->waitUntilNetworkIdle()
            ->pdf();

        // 2. Generar Excel (Reutilizamos la clase Export envolviendo al colaborador en una colección)
        $excel = Excel::raw(new CollaboratorsExport(collect([$collab])), \Maatwebsite\Excel\Excel::XLSX);

        // 3. Enviar Correo
        Mail::to($this->user->email)->send(new IndividualCollaboratorReportMail($this->user, $collab, $pdf, $excel));
    }
}
