<?php

namespace App\Http\Controllers;

use App\Models\CollaboratorRequisition;
use App\Models\VacancyStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RequisitionController extends Controller
{
    /**
     * Almacena una nueva requisición de personal.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // 1. Validaciones
        // Validamos que los IDs existan en sus respectivas tablas
        $validated = $request->validate([
            'requisition_type_id' => 'required|exists:collaborator_requisition_types,id',
            'vacancies_count'     => 'required|integer|min:1',
            // campus_id viene del form para filtros, pero validamos que el area exista
            'area_id'             => 'required|exists:areas,id', 
            'position_id'         => 'required|exists:positions,id',
            'vacancy_reason_id'   => 'required|exists:vacancy_reasons,id',
            'replaces_id'         => 'nullable|exists:collaborators,id',
            'observations'        => 'nullable|string|max:1000',
        ], [
            'requisition_type_id.required' => 'El tipo de requisición es obligatorio.',
            'requisition_type_id.exists' => 'El tipo de requisición seleccionado no es válido.',
            'vacancies_count.required' => 'El número de vacantes es obligatorio.',
            'vacancies_count.integer' => 'El número de vacantes debe ser un número entero.',
            'vacancies_count.min' => 'Debe solicitar al menos una vacante.',
            'area_id.required' => 'El área es obligatoria.',
            'area_id.exists' => 'El área seleccionada no es válida.',
            'position_id.required' => 'El cargo es obligatorio.',
            'position_id.exists' => 'El cargo seleccionado no es válido.',
            'vacancy_reason_id.required' => 'La razón de la vacante es obligatoria.',
            'vacancy_reason_id.exists' => 'La razón de vacante seleccionada no es válida.',
            'replaces_id.exists'  => 'El colaborador a reemplazar seleccionado no es válido.',
            'observations.string' => 'Las observaciones deben ser texto.',
            'observations.max' => 'Las observaciones no pueden exceder los 1000 caracteres.',
        ]);

        try {
            DB::beginTransaction();

            // 2. Obtener Contexto del Usuario
            $user = Auth::user();
            
            // Asumimos que el modelo User tiene una relación 'collaborator'
            // O que el collaborator_id está en la tabla users.
            // Ajusta esto según tu modelo real de User/Collaborator.
            $collaborator = $user->collaborator; 

            if (!$collaborator) {
                return response()->json([
                    'message' => 'Error de perfil',
                    'errors' => ['generic' => ['El usuario actual no tiene un perfil de colaborador asociado.']]
                ], 422);
            }

            // 3. Buscar el ID del Estado Inicial ("En espera de aprobación")
            // Es mejor buscar por nombre que hardcodear un ID (ej: 1 o 5)
            $initialStatus = VacancyStatus::where('name', 'En espera de aprobación')->first();
            
            if (!$initialStatus) {
                // Fallback por si no se han corrido los seeders
                throw new \Exception('El estado "En espera de aprobación" no está configurado en el sistema.');
            }

            // 4. Crear la Requisición
            $requisition = new CollaboratorRequisition();
            
            // Datos del formulario
            $requisition->requisition_type_id = $validated['requisition_type_id'];
            $requisition->vacancies_count     = $validated['vacancies_count'];
            $requisition->area_id             = $validated['area_id'];
            $requisition->position_id         = $validated['position_id'];
            $requisition->vacancy_reason_id   = $validated['vacancy_reason_id'];
            $requisition->replaces_id         = $validated['replaces_id'] ?? null;
            // Guardamos las observaciones del solicitante en un campo específico
            // Si tu tabla no tiene campo 'observations', puedes agregarlo o usar 'approval_comments' temporalmente
            // Sugiero agregar 'requester_observations' en una migración si no existe.
            $requisition->observations        = $validated['observations'] ?? null; 

            // Datos Automáticos
            $requisition->company_id        = $user->company_id ?? 1; // Ajustar según lógica de empresa
            $requisition->requested_by_id   = $collaborator->id;
            $requisition->vacancy_status_id = $initialStatus->id;
            $requisition->request_date      = Carbon::now();

            $requisition->save();

            // 5. (Opcional) Disparar Evento para Notificaciones (Emails)
            // event(new RequisitionCreated($requisition));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Requisición creada correctamente.',
                'data'    => $requisition->id
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Loguear el error real para debugging
            \Log::error('Error creando requisición: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error interno al procesar la solicitud.',
                // En desarrollo puedes descomentar la siguiente línea para ver el error:
                // 'debug_error' => $e->getMessage() 
            ], 500);
        }
    }
}
