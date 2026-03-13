<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\VacancyStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\CollaboratorRequisition;
use App\Jobs\SendRequisitionNotificationJob;
use App\Http\Requests\RequisitionCreateRequest;

class RequisitionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pendingStatusId = 1;

        $query = CollaboratorRequisition::with([
            'requisition_type',
            'position',
            'area',
            'vacancy_reason',
            'requested_by',
            'approved_by',
            'cancelled_by',
            'replaces',
            'selection_source',
            'vacancy_status'
        ]);

        // Filtro Base: Seguridad por Empresa
        $query->where('company_id', $user->company_id);

        // Lógica de Roles (Gestión vs Solicitante)
        // 3: Admin, 4: Analyst, 7: Approver
        $managementRoles = [1, 3, 4, 7];

        // Verificamos si tiene roles de gestión usando la relación directa (más eficiente)
        $isManager = $user->roles()->whereIn('id', $managementRoles)->exists();

        if (!$isManager) {
            // --- CASO SOLICITANTE (Rol 6 u otros) ---
            // Si NO es manager, filtramos para ver solo SUS requisiciones
            $collaborator = $user->collaborator;

            if ($collaborator) {
                $query->where('requested_by_id', $collaborator->id);
            } else {
                // Seguridad: Si no tiene perfil de colaborador, devolvemos lista vacía
                return response()->json([]);
            }
        }

        // 4. Ordenamiento Personalizado

        // A) Primero las Pendientes:
        // La expresión (vacancy_status_id = 1) devuelve 1 (True) o 0 (False).
        // Al ordenar DESC, los 1 (Pendientes) quedan arriba.
        $query->orderByRaw("vacancy_status_id = ? DESC", [$pendingStatusId]);

        // B) Luego por fecha (las más recientes primero dentro de su grupo)
        $query->orderBy('created_at', 'desc');

        // 5. Ejecutar
        $requisitions = $query->get();

        return response()->json($requisitions);
    }

    public function store(RequisitionCreateRequest $request)
    {
        // 1. Obtener los datos validados del Request
        // Sin esto, la variable $validated que usas abajo no existe.
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $collaborator = $user->collaborator;

            if (!$collaborator) {
                return response()->json([
                    'message' => 'Error de perfil',
                    'errors' => ['generic' => ['El usuario actual no tiene un perfil de colaborador asociado.']]
                ], 422);
            }

            $initialStatus = VacancyStatus::where('name', 'Pendiente de Aprobación')->first();

            if (!$initialStatus) {
                throw new \Exception('El estado "Pendiente de Aprobación" no está configurado en el sistema.');
            }

            // 2. Crear la Requisición utilizando asignación masiva o manual corregida
            $requisition = new CollaboratorRequisition();

            // Datos del formulario (usando el array $validated)
            $requisition->requisition_type_id = $validated['requisition_type_id'];
            $requisition->vacancies_count     = $validated['vacancies_count'];
            $requisition->area_id             = $validated['area_id'];
            $requisition->position_id         = $validated['position_id'];
            $requisition->vacancy_reason_id   = $validated['vacancy_reason_id'];
            $requisition->replaces_id         = $validated['replaces_id'] ?? null;
            $requisition->observations        = $validated['observations'] ?? null;

            // Datos Automáticos
            $requisition->company_id        = $user->company_id ?? 1;
            $requisition->requested_by_id   = $collaborator->id;
            $requisition->vacancy_status_id = $initialStatus->id;
            $requisition->request_date      = Carbon::now();

            $requisition->save();

            SendRequisitionNotificationJob::dispatch($requisition);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Requisición creada correctamente.',
                'data'    => $requisition->id
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creando requisición: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error interno al procesar la solicitud.',
            ], 500);
        }
    }

    public function update(RequisitionCreateRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $requisition = CollaboratorRequisition::findOrFail($id);

            // Validación de seguridad: Solo permitir editar si está "Pendiente"
            if ($requisition->vacancy_status_id != 1) {
                return response()->json(['message' => 'Solo se pueden editar requisiciones pendientes de aprobación.'], 422);
            }

            // Actualizamos los campos
            $requisition->requisition_type_id = $validated['requisition_type_id'];
            $requisition->vacancies_count     = $validated['vacancies_count'];
            $requisition->area_id             = $validated['area_id'];
            $requisition->position_id         = $validated['position_id'];
            $requisition->vacancy_reason_id   = $validated['vacancy_reason_id'];
            $requisition->replaces_id         = $validated['replaces_id'] ?? null;
            $requisition->observations        = $validated['observations'] ?? null;

            // Nota: No actualizamos company_id, requested_by_id ni vacancy_status_id aquí

            $requisition->save();

            SendRequisitionNotificationJob::dispatch($requisition, 'update');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Requisición actualizada correctamente.',
                'data'    => $requisition
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error actualizando requisición: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error interno al actualizar la solicitud.',
            ], 500);
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $requisition = CollaboratorRequisition::findOrFail($id);
            $user = Auth::user();
            $collaborator = $user->collaborator;

            if (!$collaborator) {
                return response()->json(['message' => 'Usuario sin perfil de colaborador asociado.'], 403);
            }

            if ($requisition->vacancy_status_id != 1) {
                return response()->json(['message' => 'La requisición no está en estado pendiente.'], 422);
            }

            $requisition->approved_by_id = $collaborator->id;
            $requisition->approved_at = Carbon::now();
            $requisition->approval_reason = $request->input('observation');
            $requisition->vacancy_status_id = 2;

            $requisition->save();

            SendRequisitionNotificationJob::dispatch($requisition, 'approve', $requisition->approval_reason);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Requisición aprobada correctamente.',
                'data' => $requisition
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error aprobando requisición: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al aprobar la solicitud.'], 500);
        }
    }

    public function cancel(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $requisition = CollaboratorRequisition::findOrFail($id);
            $user = Auth::user();
            $collaborator = $user->collaborator;

            if (!$collaborator) {
                return response()->json(['message' => 'Usuario sin perfil de colaborador asociado.'], 403);
            }

            if ($requisition->vacancy_status_id == 5) {
                return response()->json(['message' => 'La requisición ya se encuentra cancelada.'], 422);
            }

            $requisition->cancelled_by_id = $collaborator->id;
            $requisition->cancelled_at = Carbon::now();
            $requisition->cancellation_reason = $request->input('observation');
            $requisition->vacancy_status_id = 5;

            $requisition->save();

            SendRequisitionNotificationJob::dispatch($requisition, 'cancel', $requisition->cancellation_reason);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Requisición cancelada correctamente.',
                'data' => $requisition
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error cancelando requisición: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al cancelar la solicitud.'], 500);
        }
    }

    // public function changeStatus(Request $request, $id, $action)
    // {
    //     $requisition = CollaboratorRequisition::findOrFail($id);
    //     $observation = $request->input('observation'); // El comentario que envías desde Vue

    //     if ($action === 'approve') {
    //         // Lógica de aprobación
    //         $statusAprobado = VacancyStatus::where('name', 'Aprobada')->first()->id; // O el ID directo

    //         $requisition->vacancy_status_id = $statusAprobado;
    //         $requisition->approved_by_id = auth()->user()->collaborator->id;
    //         $requisition->approved_at = now();
    //         $requisition->approval_reason = $observation;
    //         $requisition->save();

    //         // NOTIFICACIÓN APROBACIÓN
    //         SendRequisitionNotificationJob::dispatch($requisition, 'approve', $observation);

    //     } elseif ($action === 'cancel') {
    //         // Lógica de cancelación
    //         $statusCancelado = VacancyStatus::where('name', 'Cancelada')->first()->id;

    //         $requisition->vacancy_status_id = $statusCancelado;
    //         $requisition->cancelled_by_id = auth()->user()->collaborator->id;
    //         $requisition->cancelled_at = now();
    //         $requisition->cancellation_reason = $observation; // Asumiendo que tienes esta columna
    //         $requisition->save();

    //         // NOTIFICACIÓN CANCELACIÓN
    //         SendRequisitionNotificationJob::dispatch($requisition, 'cancel', $observation);
    //     }

    //     return response()->json(['success' => true, 'message' => 'Estado actualizado']);
    // }
}
