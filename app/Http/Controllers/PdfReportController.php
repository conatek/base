<?php

namespace App\Http\Controllers;

use App\Jobs\SendCollaboratorReportJob;
use Illuminate\Support\Facades\Auth;

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
}