<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendCollaboratorReportJob;
use App\Jobs\SendIndividualCollaboratorReportJob;

class PdfReportController extends Controller
{
    public function downloadReportCollaborators()
    {
        $user = Auth::user();

        // Despachamos el Job
        SendCollaboratorReportJob::dispatch($user);

        return response()->json([
            'message' => 'El reporte se está procesando y se enviará a tu correo electrónico en breve.'
        ], 200);
    }

    public function downloadIndividualReport(Collaborator $collaborator)
    {
        $user = Auth::user();

        // Despachamos el Job pasando el colaborador específico
        SendIndividualCollaboratorReportJob::dispatch($user, $collaborator);

        return response()->json([
            'message' => "El reporte de {$collaborator->name} se está procesando y llegará a tu correo."
        ], 200);
    }
}