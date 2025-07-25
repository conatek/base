<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AbsenceStatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCompanyController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\CollaboratorAcademicAchievementController;
use App\Http\Controllers\CollaboratorDocumentController;
use App\Http\Controllers\CollaboratorFamilyController;
use App\Http\Controllers\CollaboratorHomeVisitController;
use App\Http\Controllers\CollaboratorMedicalExaminationController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Import\CollaboratorImportController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ProvisionController;
use App\Http\Controllers\SelectionController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\WellnessController;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('front.welcome');
})->name('start');

// Ruta para actuar como otro usuario
// Route::middleware(['auth', 'can:login-as'])->post('/login-as/{user}', function (User $user) {
Route::middleware(['auth'])->post('/login-as/{user}', function (User $user) {
    $roles = Auth::user()->roles->pluck('name')->map(fn($r) => strtolower($r))->toArray();

    if (empty(array_intersect(['master', 'super'], $roles))) {
        abort(403);
    }

    Session::put('original_user_id', Auth::id());
    Auth::login($user);

    return response()->json([
        'message' => 'Ahora estás actuando como ' . $user->name,
        'redirect' => '/home'
    ]);
});

// Ruta para volver al usuario original
Route::middleware(['auth'])->post('/return-to-original-user', function () {
    $originalUserId = Session::pull('original_user_id');

    if ($originalUserId && Auth::id() !== $originalUserId) {
        Auth::loginUsingId($originalUserId);
    }

    return response()->json([
        'message' => 'Has vuelto a tu usuario original.',
        'redirect' => '/home'
    ]);
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Route::post('/login-as/{user_id}', [UserController::class, 'loginAs']);
    Route::get('/users-data/{company_id}', [UserController::class, 'getUsers']);
    Route::get('/users/{company_id}/admin', [UserController::class, 'getUserAdmin']);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // COMPANIES
    Route::get('/companies', [CompaniesController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompaniesController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompaniesController::class, 'store'])->name('companies.store');
    Route::get('/companies/{company}', [CompaniesController::class, 'show'])->name('companies.show');
    Route::get('/companies/{company}/edit', [CompaniesController::class, 'edit'])->name('companies.edit');
    Route::put('/companies/{company}', [CompaniesController::class, 'update'])->name('companies.update');
    Route::delete('/companies/{company}/destroy', [CompaniesController::class, 'destroy'])->name('companies.destroy');

    // COMPANY DATA
    Route::get('/company', [CompanyController::class, 'companyShow'])->name('company.show');
    Route::get('/contracts-data/{company_id}', [CompanyController::class, 'getContracts']);
    Route::get('/gender-data/{company_id}', [CompanyController::class, 'getGenderData']);
    Route::get('/civil-status-data/{company_id}', [CompanyController::class, 'getCivilStatusData']);
    Route::get('/age-ranges-data/{company_id}', [CompanyController::class, 'getAgeRangesData']);
    Route::get('/academic-level-data/{company_id}', [CompanyController::class, 'getAcademicLevelData']);
    Route::get('/social-strata-data/{company_id}', [CompanyController::class, 'getSocialStrataData']);
    Route::get('/length-service-data/{company_id}', [CompanyController::class, 'getLengthServiceData']);
    Route::get('/get-next-birthdays/{company_id}', [CompanyController::class, 'getNextBirthdays']);
    Route::get('/get-expiring-contracts/{company_id}', [CompanyController::class, 'getExpiringContracts']);

    // AREAS DATA
    Route::get('/areas-data/{company_id}', [AreaController::class, 'getAreas']);
    Route::get('/areas-data/{campus_id}/campus', [AreaController::class, 'getAreasByCampus']);
    Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');
    Route::get('/areas/create', [AreaController::class, 'create'])->name('areas.create');
    Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');
    Route::get('/areas/{area}', [AreaController::class, 'show'])->name('areas.show');
    Route::get('/areas/{area}/edit', [AreaController::class, 'edit'])->name('areas.edit');
    Route::put('/areas/{area}', [AreaController::class, 'update'])->name('areas.update');
    Route::delete('/area-data-delete/{area}', [AreaController::class, 'destroy']);

    // POSITIONS DATA
    Route::get('/positions-data/{company_id}', [PositionController::class, 'getPositions']);
    Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
    Route::get('/positions/create', [PositionController::class, 'create'])->name('positions.create');
    Route::post('/positions', [PositionController::class, 'store'])->name('positions.store');
    Route::get('/positions/{position}', [PositionController::class, 'show'])->name('positions.show');
    Route::get('/positions/{position}/edit', [PositionController::class, 'edit'])->name('positions.edit');
    Route::put('/positions/{position}', [PositionController::class, 'update'])->name('positions.update');
    Route::delete('/position-data-delete/{position}', [PositionController::class, 'destroy']);

    // CAMPUSES DATA
    Route::get('/campus-data/{company_id}', [CampusController::class, 'getCampuses']);
    Route::get('/campuses', [CampusController::class, 'index'])->name('campuses.index');
    Route::get('/campuses/create', [CampusController::class, 'create']);
    Route::post('/campuses', [CampusController::class, 'store']);
    Route::get('/campuses/{campus}', [CampusController::class, 'show']);
    Route::get('/campuses/{campus}/edit', [CampusController::class, 'edit']);
    Route::put('/campuses/{campus}', [CampusController::class, 'update']);
    Route::delete('/campus-data-delete/{campus}', [CampusController::class, 'destroy']);

    // COLLABORATORS DATA
    Route::get('/collaborators-data/{company_id}', [CollaboratorController::class, 'getCollaborators']);
    Route::get('/collaborators', [CollaboratorController::class, 'index'])->name('collaborators.index');
    Route::get('/collaborators/create', [CollaboratorController::class, 'create'])->name('collaborators.create');
    Route::post('/collaborators', [CollaboratorController::class, 'store'])->name('collaborators.store');
    // Route::get('/collaborators/{collaborator}-{message?}', [CollaboratorController::class, 'show'])->name('collaborators.show');
    Route::get('/collaborators/{collaborator}', [CollaboratorController::class, 'show'])->name('collaborators.show');
    Route::get('/collaborators/{collaborator}/edit', [CollaboratorController::class, 'edit'])->name('collaborators.edit');
    Route::put('/collaborators/{collaborator}', [CollaboratorController::class, 'update'])->name('collaborators.update');
    Route::delete('/collaborators/{collaborator}/destroy', [CollaboratorController::class, 'destroy'])->name('collaborators.destroy');

    // CONTRACTUAL INFORMATION
    Route::get('/contractual-information/{collaborator_id}', [CollaboratorController::class, 'getContractualInformation']);
    Route::post('/collaborators/{collaborator}/contractual-information', [CollaboratorController::class, 'storeContractualInformation']);
    Route::put('/collaborators/{collaborator}/contractual-information', [CollaboratorController::class, 'updateContractualInformation']);

    // ROLES AND PERMISSIONS
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::get('/get-roles-and-permissions', [RoleController::class, 'getRolesAndPermissionsData']);
    Route::get('/get-roles', [RoleController::class, 'getRolesData']);
    Route::post('/toggle-permission', [RoleController::class, 'togglePermission']);

    // PROVINCES AND CITIES
    Route::post('/get-cities', [ProvinceController::class, 'getCities'])->name('get_cities');

    // RELATIVE DATA
    Route::get('/relative-data/{collaborator_id}', [CollaboratorFamilyController::class, 'show']);
    Route::post('/relative-data', [CollaboratorFamilyController::class, 'store']);
    Route::put('/relative-data-update/{relative_data}', [CollaboratorFamilyController::class, 'update']);
    Route::delete('/relative-data-delete/{relative_data}', [CollaboratorFamilyController::class, 'destroy']);

    // ACADEMIC DATA
    Route::get('/academic-data/{collaborator_id}', [CollaboratorAcademicAchievementController::class, 'show']);
    Route::post('/academic-data', [CollaboratorAcademicAchievementController::class, 'store']);
    Route::put('/academic-data-update/{academic_data}', [CollaboratorAcademicAchievementController::class, 'update']);
    Route::get('/download-academic-certificate/{academic_data_id}', [CollaboratorAcademicAchievementController::class, 'downloadCertificate']);
    Route::delete('/academic-data-delete/{academic_data}', [CollaboratorAcademicAchievementController::class, 'destroy']);

    // MEDICAL EXAMINATION DATA
    Route::get('/medical-examination-data/{collaborator_id}', [CollaboratorMedicalExaminationController::class, 'show']);
    Route::post('/medical-examination-data', [CollaboratorMedicalExaminationController::class, 'store']);
    Route::put('/medical-examination-data-update/{medical_examination_data}', [CollaboratorMedicalExaminationController::class, 'update']);
    Route::get('/download-medical-examination-result/{medical_examination_data}', [CollaboratorMedicalExaminationController::class, 'downloadResult']);
    Route::delete('/medical-examination-data-delete/{medical_examination_data}', [CollaboratorMedicalExaminationController::class, 'destroy']);

    // HOME VISIT DATA
    Route::get('/home-visit-data/{collaborator_id}', [CollaboratorHomeVisitController::class, 'show']);
    Route::post('/home-visit-data', [CollaboratorHomeVisitController::class, 'store']);
    Route::put('/home-visit-data-update/{home_visit_data}', [CollaboratorHomeVisitController::class, 'update']);
    Route::get('/download-home-visit-report/{home_visit_data}', [CollaboratorHomeVisitController::class, 'downloadReport']);
    Route::delete('/home-visit-data-delete/{home_visit_data}', [CollaboratorHomeVisitController::class, 'destroy']);

    // DOCUMENT DATA
    Route::get('/document-data/{collaborator_id}', [CollaboratorDocumentController::class, 'show']);
    Route::post('/document-data', [CollaboratorDocumentController::class, 'store']);
    Route::put('/document-data-update/{document_data}', [CollaboratorDocumentController::class, 'update']);
    Route::get('/download-document/{document_data}', [CollaboratorDocumentController::class, 'downloadDocument']);
    Route::delete('/document-data-delete/{document_data}', [CollaboratorDocumentController::class, 'destroy']);

    // LOAD COLLABORATORS


    // MODULES
    Route::get('/modules/wellness', [WellnessController::class, 'index'])->name('wellness.index');
    Route::get('/modules/selection', [SelectionController::class, 'index'])->name('selection.index');
    Route::get('/modules/absence', [AbsenceController::class, 'index'])->name('absence.index');
    Route::get('/modules/training', [TrainingController::class, 'index'])->name('training.index');
    Route::get('/modules/performance', [PerformanceController::class, 'index'])->name('performance.index');
    Route::get('/modules/provision', [ProvisionController::class, 'index'])->name('provision.index');

    // ABSENCE DATA
    Route::get('/absences', [AbsenceController::class, 'getAbsences']);
    Route::get('/absences/area/{area_id}', [AbsenceController::class, 'getAbsencesByArea']);
    Route::get('/absences/classification/{code}', [AbsenceController::class, 'getDiseaseClassificationByCode']);
    Route::get('/absences/{collaborator_id}', [AbsenceController::class, 'getAbsencesByCollaborator']);
    Route::post('/absences/{collaborator_id}', [AbsenceController::class, 'store']);
    Route::put('/absences/{absence}', [AbsenceController::class, 'update']);
    Route::put('/absences/{collaborator_id}/{absence_id}', [AbsenceController::class, 'update']);
    Route::delete('/absences/{collaborator_id}/{absence}/destroy', [AbsenceController::class, 'destroy']);
    Route::get('/absence/{absence_id}/download', [AbsenceController::class, 'downloadAbsenceSupport']);

    // ABSENCE STATUS
    Route::put('/absence-status/{absence_status_id}/update', [AbsenceStatusController::class, 'update']);
    Route::get('/absence-status/{absence_id}/download', [AbsenceStatusController::class, 'downloadAbsenceSupport']);

    // TOOLS
    Route::get('/tools/overtime', [OvertimeController::class, 'index'])->name('overtime.index');
    Route::get('/tools/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/tools/cards', [CardsController::class, 'index'])->name('cards.index');

    // MODULES DATA
    Route::get('/get-modules', [ModuleController::class, 'getModulesData']);
    Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');
    Route::put('/modules/{module}', [ModuleController::class, 'update'])->name('modules.update');
    Route::delete('/modules/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');

    // COLLABORATOR IMPORT
    Route::post('/collaborators/import', [CollaboratorImportController::class, 'import']);
});
