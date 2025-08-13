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

        // Variable para controlar el margen de impresión
        $printMargin = '5mm'; // Cambia este valor: 2mm, 3mm, 5mm, 8mm, etc.

        $html = View::make('pdf.collaborators-report', compact('collaborators', 'abbreviations', 'printMargin'))->render();

        $pdf = Browsershot::html($html)
            ->format('Letter')
            ->margins(0, 0, 0, 0) // Browsershot sin márgenes - se controla desde CSS @page
            ->noSandbox()
            ->waitUntilNetworkIdle()
            ->showBackground()
            ->printBackground()
            ->emulateMedia('print')
            ->setOption('args', [
                '--no-first-run',
                '--disable-gpu',
                '--disable-dev-shm-usage',
                '--disable-setuid-sandbox',
                '--no-zygote',
                '--single-process',
                '--disable-web-security',
                '--allow-running-insecure-content'
            ])
            ->scale(1.0)
            ->windowSize(816, 1056)
            ->pdf();

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="reporte-colaboradores.pdf"');
    }

    /**
     * Método alternativo si necesitas más control sobre la paginación
     */
    public function downloadReportCollaboratorsWithPagination()
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

        // Dividir colaboradores en grupos para mejor control de paginación
        $collaboratorsPerPage = 20; // Ajusta según el espacio disponible
        $collaboratorChunks = $collaborators->chunk($collaboratorsPerPage);

        $html = View::make('pdf.collaborators-report-paginated', compact('collaboratorChunks', 'abbreviations'))->render();

        $pdf = Browsershot::html($html)
            ->format('Letter')
            ->margins(5, 5, 5, 5)
            ->noSandbox()
            ->waitUntilNetworkIdle()
            ->showBackground()
            ->printBackground()
            ->emulateMedia('print')
            ->scale(0.9)
            ->pdf();

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="reporte-colaboradores.pdf"');
    }
}
