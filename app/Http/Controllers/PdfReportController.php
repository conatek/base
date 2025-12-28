<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaborator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Response;

class PdfReportController extends Controller
{
    public function downloadReportCollaborators()
    {
        $user = Auth::user();
        $company = $user->company;

        $collaborators = Collaborator::where('is_active', 1)
            ->whereHas('activeContract')
            ->with([
                'document_type',
                'document_province',
                'document_city',
                'birth_province',
                'birth_city',
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
                'bank_accounts.bank',

                'activeContract.position.area',
                'activeContract.contractType',

                'activeContract.bank'
            ])
            ->where('company_id', $user->company_id)
            ->orderBy('name')
            ->get();

        $html = View::make('pdf.collaborators-report', compact('company', 'collaborators'))->render();

        $pdf = Browsershot::html($html)
            ->format('Letter')
            ->margins(10, 10, 10, 10)
            ->noSandbox()
            ->waitUntilNetworkIdle() // Necesario para cargar Poppins desde Google Fonts
            ->pdf();

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf;
        }, 'reporte-colaboradores-vigentes.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
