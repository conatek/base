<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\City;
use App\Models\RhType;
use App\Models\CcfType;
use App\Models\AfpType;
use App\Models\ArlType;
use App\Models\Company;
use App\Models\EpsType;
use App\Models\SexType;
use App\Models\BankType;
use App\Models\Position;
use App\Models\Province;
use App\Models\Occupation;
use App\Models\Relationship;
use App\Models\Scholarship;
use App\Models\SocialStratum;
use App\Models\StaffProvider;
use App\Models\AbsenceType;
use App\Models\Collaborator;
use App\Models\DocumentType;
use App\Models\HomeVisitType;
use App\Models\HousingTenure;
use App\Models\ContractType;
use App\Models\AbsenceSubtype;
use App\Models\CivilStatusType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalExaminationType;
use App\Models\AcademicAchievementType;
use App\Models\ContractualDocumentType;
use App\Http\Requests\CollaboratorEditRequest;
use App\Models\CollaboratorAcademicAchievement;
use App\Http\Requests\CollaboratorCreateRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CollaboratorController extends Controller
{
    public function __construct()
    {
        // Aplicamos el middleware AJAX solo a métodos específicos
        $this->middleware(function ($request, $next) {
            if (!request()->ajax()) {
                abort(403, 'Acceso denegado');
            }
            return $next($request);
        })->except(['index']);
    }

    // public function getCollaborators()
    // {
    //     // dd('getCollaborators');
    //     $user = Auth::user();
    //     $today = now()->toDateString();

    //     $collaborators = Collaborator::where('company_id', $user->company_id)
    //         ->with('position') // tu relación actual
    //         ->withCount([
    //             // Cuenta cuántos contratos vigentes hay hoy
    //             'contracts as has_active_contract' => function ($q) use ($today) {
    //                 $q->whereDate('contract_start_date', '<=', $today)
    //                 ->where(function ($qq) use ($today) {
    //                     $qq->whereNull('contract_end_date')
    //                         ->orWhereDate('contract_end_date', '>=', $today);
    //                 });
    //             },
    //         ])
    //         ->orderByDesc('created_at')
    //         ->get()
    //         // Convertimos el count (0/1/...) a booleano y con el nombre camelCase pedido:
    //         ->map(function ($c) {
    //             $c->hasActiveContract = (bool) $c->has_active_contract;
    //             unset($c->has_active_contract); // opcional: oculta el count original
    //             return $c;
    //         });

    //     return [
    //         'collaborators' => $collaborators,
    //     ];
    // }

    public function getCollaborators()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $collaborators = Collaborator::where('company_id', $user->company_id)
            ->with('position')
            ->withCount([
                'contracts as has_active_contract' => function ($q) use ($today) {
                    $q->whereDate('contract_start_date', '<=', $today)
                    ->where(function ($qq) use ($today) {
                        $qq->whereNull('contract_end_date')
                            ->orWhereDate('contract_end_date', '>=', $today);
                    });
                },
            ])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($c) {
                // Tu lógica existente de contratos
                $c->hasActiveContract = (bool) $c->has_active_contract;
                unset($c->has_active_contract);
                
                // --- NUEVA LÓGICA ---
                // Inyectamos el resultado del Accessor en el objeto JSON
                // Laravel snake_casea el accessor automáticamente al serializar si se usa append,
                // pero aquí lo estamos asignando explícitamente para control total.
                $c->isProfileComplete = $c->is_profile_complete; 
                
                return $c;
            });

        return [
            'collaborators' => $collaborators,
        ];
    }

    public function getCollaboratorsData() {
        $results = [];

        $user = Auth::user();

        $user_company_id = $user->company_id;
        $collaborators = Collaborator::where('company_id', $user_company_id)->get();
        $collaborators_data = [];

        foreach ($collaborators as $collaborator) {
            $data = [];

            $data['id'] = $collaborator->id;
            $data['name'] = $collaborator->name;
            $data['first_surname'] = $collaborator->first_surname;
            $data['second_surname'] = $collaborator->second_surname;

            array_push($collaborators_data, $data);
        }

        $results['collaborators'] = $collaborators_data;

        return $results;
    }

    public function index()
    {
        // abort_if(Gate::denies('collaborator_index'), 403);

        $user = Auth::user();
        $company = Company::where('id', $user->company_id)->first();
        // $collaborators = Collaborator::where('company_id', $company->id)->orderBy('created_at', 'desc')->with('position')->get();
        $absence_types = AbsenceType::all();
        $absence_subtypes = AbsenceSubtype::all();
        // $staff_providers = StaffProvider::all();

        // return view('back.collaborators.index', compact('company', 'collaborators', 'absence_types', 'absence_subtypes'));
        return view('back.collaborators.index', compact('company', 'absence_types', 'absence_subtypes'));
    }

    public function create()
    {
        // dd('create');
        $result = [];

        $user = Auth::user();
        $company = Company::where('id', $user->company_id)->first();

        // abort_if(Gate::denies('collaborator_create'), 403);

        $document_types = DocumentType::all();
        $sex_types = SexType::all();
        $rh_types = RhType::all();
        // $academic_achievement_types = AcademicAchievementType::all();
        $stratum_types = SocialStratum::all();
        $civil_status_types = CivilStatusType::all();
        $housing_tenure_types = HousingTenure::all();
        $provinces = Province::all();
        $staff_providers = StaffProvider::where('company_id', $company->id)->orderBy('id', 'asc')->get();

        // return view('back.collaborators.create', compact('company', 'document_types', 'sex_types', 'rh_types', 'stratum_types', 'civil_status_types', 'housing_tenure_types', 'provinces'));

        $result['company'] = $company;
        $result['document_types'] = $document_types;
        $result['sex_types'] = $sex_types;
        $result['rh_types'] = $rh_types;
        $result['stratum_types'] = $stratum_types;
        $result['civil_status_types'] = $civil_status_types;
        $result['housing_tenure_types'] = $housing_tenure_types;
        $result['provinces'] = $provinces;
        $result['staff_providers'] = $staff_providers;

        return $result;
    }

    public function store(CollaboratorCreateRequest $request)
    {
        try {
            // 1. Obtenemos los datos validados automáticamente del Request
            // Esto crea un array con todos los campos definidos en rules()
            $data = $request->validated();

            // 2. Agregamos datos que no vienen del formulario (Company ID)
            $company_id = Auth::user()->company_id;
            $data['company_id'] = $company_id;

            // 3. Lógica de Extranjero (Sanitización de datos)
            // Convertimos a booleano real para evaluar
            if ($request->boolean('is_foreigner')) {
                // Forzamos NULL aunque el frontend envíe algo
                $data['birth_province_id'] = null;
                $data['birth_city_id'] = null;
                $data['is_foreigner'] = 1;
            } else {
                $data['is_foreigner'] = 0;
            }

            // 4. Manejo de Imagen con Cloudinary
            // Sacamos la lógica del array para no repetir código
            if ($request->hasFile('image')) {
                $file = $request->file('image');

                // Buena práctica: usar config() en lugar de env()
                $environment = config('app.env', 'local');
                $folderPath = "mh/{$environment}/{$company_id}/collaborators";

                // Subida a Cloudinary
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), [
                    'folder' => $folderPath
                ]);

                // Agregamos las URLs al array de datos
                $data['image_public_id'] = $cloudinary_object->getPublicId();
                $data['image_url'] = $cloudinary_object->getSecurePath();
            }

            // IMPORTANTE: El $request->validated() incluye el campo 'image' (el archivo binario).
            // Si tu tabla NO tiene una columna llamada 'image', debes quitarla del array
            // para evitar error de SQL "Column not found".
            unset($data['image']);

            // 5. Creación
            $collaborator = Collaborator::create($data);

            return response()->json([
                'message' => 'Colaborador creado exitosamente!',
                'collaborator' => $collaborator
            ], 201); // 201 Created es el código HTTP correcto para creación

        } catch (\Exception $e) {
            // Loguear el error es buena práctica para depurar sin exponer info al usuario
            Log::error('Error creando colaborador: ' . $e->getMessage());

            return response()->json([
                'message' => 'Hubo un error al guardar el colaborador.'
                // 'error' => $e->getMessage() // Descomenta solo en desarrollo
            ], 500);
        }
    }

    public function show(Collaborator $collaborator)
    {
        $result = [];

        $user = Auth::user();

        // if (request()->ajax()) {
        //     if($user->company_id != $collaborator->company_id) {
        //         abort(403, 'No autorizado');
        //     }
        // } else {
        //     abort(403, 'No autorizado');
        // }

        $company = Company::where('id', $collaborator->company_id)->first();

        // abort_if(Gate::denies('collaborator_show'), 403);

        $document_type = DocumentType::where('id', $collaborator->document_type_id)->first();
        $document_province = Province::where('id', $collaborator->document_province_id)->first();
        $document_city = City::where('id', $collaborator->document_city_id)->first();
        $birth_province = Province::where('id', $collaborator->birth_province_id)->first();
        $birth_city = City::where('id', $collaborator->birth_city_id)->first();
        $residence_province = Province::where('id', $collaborator->residence_province_id)->first();
        $residence_city = City::where('id', $collaborator->residence_city_id)->first();
        $civil_status = CivilStatusType::where('id', $collaborator->civil_status_type_id)->first();
        $sex_type = SexType::where('id', $collaborator->sex_type_id)->first();
        $rh_type = RhType::where('id', $collaborator->rh_type_id)->first();
        $scholarship_type = Scholarship::where('id', $collaborator->scholarship_type_id)->first();

        $highest_academic_achievement = CollaboratorAcademicAchievement::where('collaborator_id', $collaborator->id)
            ->join('academic_achievement_types', 'collaborator_academic_achievements.achievement_type_id', '=', 'academic_achievement_types.id')
            ->orderBy('collaborator_academic_achievements.achievement_type_id', 'desc')
            ->select('academic_achievement_types.*')
            ->first();

        if($highest_academic_achievement == null) {
            $highest_academic_achievement = new AcademicAchievementType();
            $highest_academic_achievement->type = 'Sin asignar';
        }

        $stratum_type = SocialStratum::where('id', $collaborator->stratum_type_id)->first();
        $housing_tenure = HousingTenure::where('id', $collaborator->housing_tenure_id)->first();

        $relationship_types = Relationship::all();
        $occupation_types = Occupation::all();
        $sex_types = SexType::all();
        $achievement_types = AcademicAchievementType::all();
        $examination_types = MedicalExaminationType::all();
        $home_visit_types = HomeVisitType::all();
        $contractual_documents_types = ContractualDocumentType::all();

        $relationship_type = Relationship::where('id', $collaborator->relationship_id)->first();
        $occupation_type = Occupation::where('id', $collaborator->occupation_id)->first();
        $staff_provider = StaffProvider::where('id', $collaborator->staff_provider_id)->first();

        $result['company'] = $company;
        $result['collaborator'] = $collaborator;
        $result['document_type'] = $document_type;
        $result['document_province'] = $document_province;
        $result['document_city'] = $document_city;
        $result['birth_province'] = $birth_province;
        $result['birth_city'] = $birth_city;
        $result['residence_province'] = $residence_province;
        $result['residence_city'] = $residence_city;
        $result['civil_status'] = $civil_status;
        $result['sex_type'] = $sex_type;
        $result['rh_type'] = $rh_type;
        $result['highest_academic_achievement'] = $highest_academic_achievement;
        $result['stratum_type'] = $stratum_type;
        $result['housing_tenure'] = $housing_tenure;
        $result['staff_provider'] = $staff_provider;
        $result['relationship_types'] = $relationship_types;
        $result['relationship_type'] = $relationship_type;
        $result['occupation_types'] = $occupation_types;
        $result['occupation_type'] = $occupation_type;
        $result['sex_types'] = $sex_types;
        $result['achievement_types'] = $achievement_types;
        $result['examination_types'] = $examination_types;
        $result['home_visit_types'] = $home_visit_types;
        $result['contractual_documents_types'] = $contractual_documents_types;

        return $result;
    }

    public function edit(Collaborator $collaborator)
    {
        $result = [];

        $user = Auth::user();
        $company = Company::where('id', $user->company_id)->first();

        // abort_if(Gate::denies('collaborator_edit'), 403);

        $document_types = DocumentType::all();
        $sex_types = SexType::all();
        $rh_types = RhType::all();
        $stratum_types = SocialStratum::all();
        $civil_status_types = CivilStatusType::all();
        $housing_tenure_types = HousingTenure::all();
        $provinces = Province::all();

        $position_types = Position::where('company_id',$company->id)->get();
        $contract_types = ContractType::all();
        $bank_types = BankType::all();
        $eps_types = EpsType::all();
        $afp_types = AfpType::all();
        $arl_types = ArlType::all();
        $ccf_types = CcfType::all();
        $staff_providers = StaffProvider::where('company_id', $company->id)->orderBy('id', 'asc')->get();

        $result['document_types'] = $document_types;
        $result['sex_types'] = $sex_types;
        $result['rh_types'] = $rh_types;
        $result['stratum_types'] = $stratum_types;
        $result['civil_status_types'] = $civil_status_types;
        $result['housing_tenure_types'] = $housing_tenure_types;
        $result['provinces'] = $provinces;
        $result['position_types'] = $position_types;
        $result['contract_types'] = $contract_types;
        $result['bank_types'] = $bank_types;
        $result['eps_types'] = $eps_types;
        $result['afp_types'] = $afp_types;
        $result['arl_types'] = $arl_types;
        $result['ccf_types'] = $ccf_types;
        $result['staff_providers'] = $staff_providers;

        return $result;
    }

    // public function update(CollaboratorEditRequest $request, Collaborator $collaborator)
    // {
    //     try {
    //         // 1. Obtenemos datos validados (limpieza automática)
    //         $data = $request->validated();

    //         // 2. Company ID (generalmente no se actualiza, pero si es necesario, se deja)
    //         $data['company_id'] = Auth::user()->company_id;

    //         // 3. Lógica de Extranjero
    //         if ($request->boolean('is_foreigner')) {
    //             $data['birth_province_id'] = null;
    //             $data['birth_city_id'] = null;
    //             $data['is_foreigner'] = 1;
    //         } else {
    //             $data['is_foreigner'] = 0;
    //         }

    //         // 4. Manejo de Imagen
    //         if ($request->hasFile('image')) {
    //             // A. Borrar imagen anterior de Cloudinary si existe
    //             if ($collaborator->image_public_id) {
    //                 Cloudinary::destroy($collaborator->image_public_id);
    //             }

    //             // B. Subir nueva imagen
    //             $file = $request->file('image');
    //             $company_id = Auth::user()->company_id;
    //             $environment = config('app.env', 'local'); // Uso correcto de config

    //             $cloudinary_object = Cloudinary::upload($file->getRealPath(), [
    //                 'folder' => "mh/{$environment}/{$company_id}/collaborators"
    //             ]);

    //             $data['image_public_id'] = $cloudinary_object->getPublicId();
    //             $data['image_url'] = $cloudinary_object->getSecurePath();
    //         }

    //         // IMPORTANTE: Quitamos el objeto 'image' binario del array para que no rompa el SQL
    //         unset($data['image']);

    //         // NOTA: Si NO se subió imagen, $data no tiene las llaves 'image_url' ni 'image_public_id',
    //         // por lo que el método update() de Eloquent simplemente no tocará esas columnas en la BD.
    //         // Esto es mucho más limpio que asignar manualmente $old_url.

    //         // 5. Actualizar
    //         $collaborator->update($data);

    //         return response()->json([
    //             'message' => 'Colaborador actualizado exitosamente!',
    //             'collaborator' => $collaborator
    //         ]);

    //     } catch (\Exception $e) {
    //         Log::error("Error actualizando colaborador ID {$collaborator->id}: " . $e->getMessage());

    //         return response()->json([
    //             'message' => 'Hubo un error al actualizar el colaborador.'
    //             // 'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function update(CollaboratorEditRequest $request, Collaborator $collaborator)
    {
        // dd($request->all());
        try {
            // Envolvemos todo en una transacción
            return DB::transaction(function () use ($request, $collaborator) {
                
                // 1. Obtener datos validados
                $data = $request->validated();
                // dd($data);
                $data['company_id'] = Auth::user()->company_id;

                // 2. Lógica de Extranjero
                if ($request->boolean('is_foreigner')) {
                    $data['birth_province_id'] = null;
                    $data['birth_city_id'] = null;
                    $data['is_foreigner'] = 1;
                } else {
                    $data['is_foreigner'] = 0;
                }

                // 3. Manejo de Imagen
                if ($request->hasFile('image')) {
                    if ($collaborator->image_public_id) {
                        Cloudinary::destroy($collaborator->image_public_id);
                    }

                    $file = $request->file('image');
                    $company_id = Auth::user()->company_id;
                    $environment = config('app.env', 'local');

                    $cloudinary_object = Cloudinary::upload($file->getRealPath(), [
                        'folder' => "mh/{$environment}/{$company_id}/collaborators"
                    ]);

                    $data['image_public_id'] = $cloudinary_object->getPublicId();
                    $data['image_url'] = $cloudinary_object->getSecurePath();
                    
                    // NOTA: Si quisieras sincronizar la imagen también con el User, este sería el lugar.
                    // Pero generalmente User y Colaborador pueden tener fotos distintas (una formal, otra perfil).
                    // Si decides sincronizar, guarda estos valores en variables para usarlos abajo.
                }
                unset($data['image']);

                // 4. Actualizar COLABORADOR
                // dd($data);
                $collaborator->update($data);

                // 5. SINCRONIZAR USUARIO ASOCIADO (NUEVA LÓGICA)
                // Verificamos si el colaborador tiene un usuario vinculado
                if ($collaborator->user) {
                    // Preparamos solo los datos de identidad que queremos reflejar
                    $userDataToSync = [
                        'name'           => $data['name'],
                        'first_surname'  => $data['first_surname'],
                        'second_surname' => $data['second_surname'] ?? null,
                        'email'          => $data['email'],
                    ];
                    
                    // Actualizamos el usuario
                    $collaborator->user->update($userDataToSync);
                }

                return response()->json([
                    'message' => 'Colaborador actualizado exitosamente!',
                    'collaborator' => $collaborator
                ]);

            }); // Fin de la transacción

        } catch (\Exception $e) {
            Log::error("Error actualizando colaborador ID {$collaborator->id}: " . $e->getMessage());

            return response()->json([
                'message' => 'Hubo un error al actualizar el colaborador.'
            ], 500);
        }
    }

    public function destroy(Collaborator $collaborator)
    {
        // abort_if(Gate::denies('collaborator_destroy'), 403);

        // try {
            if(isset($collaborator['image_public_id'])) {
                $public_id = $collaborator['image_public_id'];
                Cloudinary::destroy($public_id);
            }

            $collaborator->delete();

            return response()->json([
                'message'=>'Colaborador eliminado exitosamente!',
                'collaborator'=>$collaborator
            ]);
        // } catch (Exception $e) {
        //     return response()->json([
        //         'message' => $e->getMessage()
        //     ]);
        // }
    }

    public function deactivate(Collaborator $collaborator)
    {
        $collaborator->update(['is_active' => 0]);

        return response()->json([
            'message' => 'Colaborador inactivado exitosamente!',
            'collaborator' => $collaborator
        ]);
    }

    public function activate(Collaborator $collaborator)
    {
        $collaborator->update(['is_active' => 1]);

        return response()->json([
            'message' => 'Colaborador activado exitosamente!',
            'collaborator' => $collaborator
        ]);
    }
}
