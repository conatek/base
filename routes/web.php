<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\WellnessController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PdfReportController;
use App\Http\Controllers\ProvisionController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\SelectionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\UserCompanyController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\StaffProviderController;
use App\Http\Controllers\AbsenceStatusController;
use App\Http\Controllers\SelfManagementController;
use App\Http\Controllers\CollaboratorFamilyController;
use App\Http\Controllers\CollaboratorDocumentController;
use App\Http\Controllers\CollaboratorHomeVisitController;
use App\Http\Controllers\CollaboratorBankAccountController;
use App\Http\Controllers\Import\CollaboratorImportController;
use App\Http\Controllers\CollaboratorSocialSecurityController;
use App\Http\Controllers\CollaboratorMedicalExaminationController;
use App\Http\Controllers\CollaboratorAcademicAchievementController;
use App\Http\Controllers\Api\MeController;


// ─── Rutas nombradas para el SPA ─────────────────────────────────────────────
Route::get('/', fn () => view('spa'))->name('start');
Route::get('/home', fn () => view('spa'))->name('home');
Route::get('/roles', fn () => view('spa'))->name('roles.index');
Route::get('/users', fn () => view('spa'))->name('users.index');
Route::get('/company/{id?}', fn () => view('spa'))->name('company.show');
Route::get('/modules/selection', fn () => view('spa'));
Route::get('/modules/provision', fn () => view('spa'))->name('provision.index');
Route::get('/modules/training', fn () => view('spa'))->name('training.index');
Route::get('/modules/performance', fn () => view('spa'))->name('performance.index');
Route::get('/modules/wellness', fn () => view('spa'))->name('wellness.index');
Route::get('/self-management/profile', fn () => view('spa'))->name('self-management.profile');
Route::get('/tools/overtime', fn () => view('spa'))->name('overtime.index');
Route::get('/tools/inventory', fn () => view('spa'))->name('inventory.index');
Route::get('/tools/cards', fn () => view('spa'))->name('cards.index');

// ─── Impersonación ───────────────────────────────────────────────────────────
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

// ─── API interna (sesión web) ─────────────────────────────────────────────────
Route::middleware('auth')->get('/api/me', MeController::class);

// ─── Rutas autenticadas ───────────────────────────────────────────────────────
Route::group(['middleware' => 'auth'], function () {

    // USERS DATA (JSON)
    Route::get('/users-data/{company_id}', [UserController::class, 'getUsers']);
    Route::get('/users/{company_id}/admin', [UserController::class, 'getUserAdmin']);
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // COMPANIES AJAX ENDPOINTS (usados por CompanyIndex.vue internamente)
    Route::get('/companies', [CompaniesController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompaniesController::class, 'create']);
    Route::get('/companies/{company}/edit', [CompaniesController::class, 'edit']);
    Route::get('/companies/{company}', [CompaniesController::class, 'show']);

    // COLLABORATORS AJAX ENDPOINTS (usados por CollaboratorIndex.vue internamente)
    Route::get('/collaborators-data', [CollaboratorController::class, 'create']);
    Route::get('/collaborators/{collaborator}/show', [CollaboratorController::class, 'show']);
    Route::get('/collaborators/{collaborator}/edit', [CollaboratorController::class, 'edit']);

    // COMPANIES DATA (JSON)
    Route::get('/contracts-data/{company_id}', [CompanyController::class, 'getContracts']);
    Route::get('/gender-data/{company_id}', [CompanyController::class, 'getGenderData']);
    Route::get('/civil-status-data/{company_id}', [CompanyController::class, 'getCivilStatusData']);
    Route::get('/age-ranges-data/{company_id}', [CompanyController::class, 'getAgeRangesData']);
    Route::get('/academic-level-data/{company_id}', [CompanyController::class, 'getAcademicLevelData']);
    Route::get('/social-strata-data/{company_id}', [CompanyController::class, 'getSocialStrataData']);
    Route::get('/length-service-data/{company_id}', [CompanyController::class, 'getLengthServiceData']);
    Route::get('/get-next-birthdays/{company_id}', [CompanyController::class, 'getNextBirthdays']);
    Route::get('/get-expiring-contracts/{company_id}', [CompanyController::class, 'getExpiringContracts']);
    Route::post('/companies', [CompaniesController::class, 'store'])->name('companies.store');
    Route::put('/companies/{company}', [CompaniesController::class, 'update'])->name('companies.update');
    Route::delete('/companies/{company}/destroy', [CompaniesController::class, 'destroy'])->name('companies.destroy');

    // AREAS DATA (JSON)
    Route::get('/areas-data/{company_id}', [AreaController::class, 'getAreas']);
    Route::get('/areas-data/{campus_id}/campus', [AreaController::class, 'getAreasByCampus']);
    Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');
    Route::put('/areas/{area}', [AreaController::class, 'update'])->name('areas.update');
    Route::delete('/area-data-delete/{area}', [AreaController::class, 'destroy']);

    // POSITIONS DATA (JSON)
    Route::get('/positions-data/{company_id}', [PositionController::class, 'getPositions']);
    Route::post('/positions', [PositionController::class, 'store'])->name('positions.store');
    Route::put('/positions/{position}', [PositionController::class, 'update'])->name('positions.update');
    Route::delete('/position-data-delete/{position}', [PositionController::class, 'destroy']);

    // CAMPUSES DATA (JSON)
    Route::get('/campus-data/{company_id}', [CampusController::class, 'getCampuses']);
    Route::post('/campuses', [CampusController::class, 'store']);
    Route::put('/campuses/{campus}', [CampusController::class, 'update']);
    Route::delete('/campus-data-delete/{campus}', [CampusController::class, 'destroy']);

    // COLLABORATORS DATA (JSON)
    Route::get('/collaborators', [CollaboratorController::class, 'index'])->name('collaborators.index');
    Route::get('/collaborators/{company_id}', [CollaboratorController::class, 'getCollaborators']);
    Route::get('/collaborators-data/{company_id}', [CollaboratorController::class, 'getCollaboratorsData']);
    Route::post('/collaborators', [CollaboratorController::class, 'store'])->name('collaborators.store');
    Route::put('/collaborators/{collaborator}', [CollaboratorController::class, 'update'])->name('collaborators.update');
    Route::delete('/collaborators/{collaborator}/destroy', [CollaboratorController::class, 'destroy'])->name('collaborators.destroy');
    Route::put('/collaborators/{collaborator}/deactivate', [CollaboratorController::class, 'deactivate'])->name('collaborators.deactivate');
    Route::put('/collaborators/{collaborator}/activate', [CollaboratorController::class, 'activate'])->name('collaborators.activate');

    // CONTRACTUAL INFORMATION (JSON)
    Route::get('/contracts/{collaborator_id}', [ContractController::class, 'getContracts']);
    Route::get('/contractual-information', [ContractController::class, 'getContractualInformation']);
    Route::get('/contractual-information/{collaborator_id}', [ContractController::class, 'getActiveContractByCollaborator']);
    Route::post('/contracts/{collaborator}', [ContractController::class, 'store']);
    Route::put('/contracts/{contract}', [ContractController::class, 'update']);
    Route::delete('/contracts/{contract}', [ContractController::class, 'destroy']);

    // SOCIAL SECURITY (JSON + downloads)
    Route::get('/social-security-information', [CollaboratorSocialSecurityController::class, 'getSocialSecurityInformation']);
    Route::get('/social-security-information/{collaborator_id}', [CollaboratorSocialSecurityController::class, 'getSocialSecurityByCollaborator']);
    Route::post('/social-security-information', [CollaboratorSocialSecurityController::class, 'store']);
    Route::get('/download-eps-certificate/{social_security_id}', [CollaboratorSocialSecurityController::class, 'downloadEpsCertificate']);
    Route::get('/download-afp-pension-certificate/{social_security_id}', [CollaboratorSocialSecurityController::class, 'downloadAfpPensionCertificate']);
    Route::get('/download-afp-saving-certificate/{social_security_id}', [CollaboratorSocialSecurityController::class, 'downloadAfpSavingCertificate']);
    Route::put('/social-security-information/{social_security_id}', [CollaboratorSocialSecurityController::class, 'update']);
    Route::delete('/social-security-information/{social_security_id}', [CollaboratorSocialSecurityController::class, 'destroy']);

    // BANK INFORMATION (JSON + downloads)
    Route::get('/bank-account-information', [CollaboratorBankAccountController::class, 'getBankAccountInformation']);
    Route::get('/bank-account-information/{collaborator_id}', [CollaboratorBankAccountController::class, 'getBankAccountByCollaborator']);
    Route::post('/bank-account-information', [CollaboratorBankAccountController::class, 'store']);
    Route::get('/download-bank-account-certificate/{bank_account_id}', [CollaboratorBankAccountController::class, 'downloadCertificate']);
    Route::put('/bank-account-information/{bank_account}', [CollaboratorBankAccountController::class, 'update']);
    Route::delete('/bank-account-information/{bank_account}', [CollaboratorBankAccountController::class, 'destroy']);

    // ROLES AND PERMISSIONS (JSON)
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/get-roles-and-permissions', [RoleController::class, 'getRolesAndPermissionsData']);
    Route::get('/get-roles', [RoleController::class, 'getRolesData']);
    Route::post('/toggle-permission', [RoleController::class, 'togglePermission']);

    // PROVINCES AND CITIES (JSON)
    Route::post('/get-cities', [ProvinceController::class, 'getCities'])->name('get_cities');

    // RELATIVE DATA (JSON)
    Route::get('/relative-data/{collaborator_id}', [CollaboratorFamilyController::class, 'show']);
    Route::post('/relative-data', [CollaboratorFamilyController::class, 'store']);
    Route::put('/relative-data-update/{relative_data}', [CollaboratorFamilyController::class, 'update']);
    Route::delete('/relative-data-delete/{relative_data}', [CollaboratorFamilyController::class, 'destroy']);

    // ACADEMIC DATA (JSON + downloads)
    Route::get('/academic-data/{collaborator_id}', [CollaboratorAcademicAchievementController::class, 'show']);
    Route::post('/academic-data', [CollaboratorAcademicAchievementController::class, 'store']);
    Route::put('/academic-data-update/{academic_data}', [CollaboratorAcademicAchievementController::class, 'update']);
    Route::get('/download-academic-certificate/{academic_data_id}', [CollaboratorAcademicAchievementController::class, 'downloadCertificate']);
    Route::delete('/academic-data-delete/{academic_data}', [CollaboratorAcademicAchievementController::class, 'destroy']);

    // MEDICAL EXAMINATION DATA (JSON + downloads)
    Route::get('/medical-examination-data/{collaborator_id}', [CollaboratorMedicalExaminationController::class, 'show']);
    Route::post('/medical-examination-data', [CollaboratorMedicalExaminationController::class, 'store']);
    Route::put('/medical-examination-data-update/{medical_examination_data}', [CollaboratorMedicalExaminationController::class, 'update']);
    Route::get('/download-medical-examination-result/{medical_examination_data}', [CollaboratorMedicalExaminationController::class, 'downloadResult']);
    Route::delete('/medical-examination-data-delete/{medical_examination_data}', [CollaboratorMedicalExaminationController::class, 'destroy']);

    // HOME VISIT DATA (JSON + downloads)
    Route::get('/home-visit-data/{collaborator_id}', [CollaboratorHomeVisitController::class, 'show']);
    Route::post('/home-visit-data', [CollaboratorHomeVisitController::class, 'store']);
    Route::put('/home-visit-data-update/{home_visit_data}', [CollaboratorHomeVisitController::class, 'update']);
    Route::get('/download-home-visit-report/{home_visit_data}', [CollaboratorHomeVisitController::class, 'downloadReport']);
    Route::delete('/home-visit-data-delete/{home_visit_data}', [CollaboratorHomeVisitController::class, 'destroy']);

    // DOCUMENT DATA (JSON + downloads)
    Route::get('/document-data/{collaborator_id}', [CollaboratorDocumentController::class, 'show']);
    Route::post('/document-data', [CollaboratorDocumentController::class, 'store']);
    Route::put('/document-data-update/{document_data}', [CollaboratorDocumentController::class, 'update']);
    Route::get('/download-document/{document_data}', [CollaboratorDocumentController::class, 'downloadDocument']);
    Route::delete('/document-data-delete/{document_data}', [CollaboratorDocumentController::class, 'destroy']);

    // SELECTION FORM DATA (JSON)
    Route::get('/modules/selection', [SelectionController::class, 'index'])->name('selection.index');

    // SELECTION DATA (JSON)
    Route::get('/selection/collaborator-requisitions', [RequisitionController::class, 'index']);
    Route::post('/selection/collaborator-requisitions', [RequisitionController::class, 'store']);
    Route::put('/selection/collaborator-requisitions/{id}', [RequisitionController::class, 'update']);
    Route::put('/requisitions/{id}/approve', [RequisitionController::class, 'approve']);
    Route::put('/requisitions/{id}/cancel', [RequisitionController::class, 'cancel']);

    // ABSENCE FORM DATA (JSON)
    Route::get('/modules/absence', [AbsenceController::class, 'index'])->name('absence.index');

    // ABSENCE DATA (JSON + downloads)
    Route::get('/absences', [AbsenceController::class, 'getAbsences']);
    Route::get('/absences/area/{area_id}', [AbsenceController::class, 'getAbsencesByArea']);
    Route::get('/absences/classification/{code}', [AbsenceController::class, 'getDiseaseClassificationByCode']);
    Route::get('/absences/{collaborator_id}', [AbsenceController::class, 'getAbsencesByCollaborator']);
    Route::post('/absences/{collaborator_id}', [AbsenceController::class, 'store']);
    Route::put('/absences/{absence}', [AbsenceController::class, 'update']);
    Route::put('/absences/{collaborator_id}/{absence_id}', [AbsenceController::class, 'update']);
    Route::delete('/absences/{collaborator_id}/{absence}/destroy', [AbsenceController::class, 'destroy']);
    Route::get('/absence/{absence_id}/download', [AbsenceController::class, 'downloadAbsenceSupport']);

    // ABSENCE STATUS (JSON + downloads)
    Route::put('/absence-status/{absence_status_id}/update', [AbsenceStatusController::class, 'update']);
    Route::get('/absence-status/{absence_id}/download', [AbsenceStatusController::class, 'downloadAbsenceSupport']);

    // MODULES DATA (JSON)
    Route::get('/get-modules', [ModuleController::class, 'getModulesData']);
    Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');
    Route::put('/modules/{module}', [ModuleController::class, 'update'])->name('modules.update');
    Route::delete('/modules/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');

    // COLLABORATOR IMPORT
    Route::post('/collaborators/import', [CollaboratorImportController::class, 'import']);

    // PDF REPORTS (downloads — se mantienen como rutas de servidor)
    Route::get('/report/collaborators', [PdfReportController::class, 'downloadReportCollaborators']);
    Route::get('/report/collaborator/{collaborator}', [PdfReportController::class, 'downloadIndividualReport']);

    // PROVIDERS DATA (JSON)
    Route::get('/staff-providers', [StaffProviderController::class, 'index'])->name('staff-providers.index');
    Route::get('/providers-data/{company_id}', [StaffProviderController::class, 'getProvidersData']);
    Route::post('/staff-providers', [StaffProviderController::class, 'store'])->name('staff-providers.store');
    Route::put('/staff-providers/{provider}', [StaffProviderController::class, 'update'])->name('staff-providers.update');
    Route::delete('/staff-providers/{provider}', [StaffProviderController::class, 'destroy'])->name('staff-providers.destroy');
});

// ─── Catch-all SPA — debe ser la última ruta ─────────────────────────────────
// Sirve el SPA para cualquier ruta GET no capturada arriba.
// Vue Router se encarga de la navegación del lado del cliente.
Route::get('/{any}', fn () => view('spa'))->where('any', '.*');
