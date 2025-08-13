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

        $collaborators = Collaborator::where('company_id', $user->company_id)
            ->orderBy('name')
            ->get();

        $abbreviations = [
            'Cédula de ciudadanía'     => 'CC',
            'Cédula de extranjería'    => 'CE',
            'NIT'                      => 'NIT',
            'NUIP'                     => 'NUIP',
            'Pasaporte'               => 'PP',
            'Tarjeta de identidad'     => 'TI',
        ];

        $html = View::make('pdf.collaborators-report', compact('collaborators', 'abbreviations'))->render();

        $pdf = Browsershot::html($html)
            ->format('Letter') // tamaño carta
            ->margins(10, 0, 10, 0)
            ->noSandbox() // útil en algunos servidores
            ->waitUntilNetworkIdle()
            ->pdf();

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="reporte-colaboradores.pdf"');
    }
}
