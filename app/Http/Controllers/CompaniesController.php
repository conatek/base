<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\City;
use App\Models\Company;
use App\Models\Industry;
use App\Models\Province;
use App\Models\CompanyType;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Models\StaffProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CompanyEditRequest;
use App\Http\Requests\CompanyCreateRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CompaniesController extends Controller
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

        $this->middleware('can:companies_index')->only(['index']);
    }

    public function index()
    {
        // abort_if(Gate::denies('company_index'), 403, 'ACCESO DENEGADO');

        $companies = Company::orderBy('created_at', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('back.companies.index', compact('companies'));
    }

    public function create()
    {
        // abort_if(Gate::denies('company_create'), 403);

        $result = [];

        $company_types = CompanyType::all();
        $document_types = DocumentType::all();
        $provinces = Province::all();
        $industry_types = Industry::all();

        $result['company_types'] = $company_types;
        $result['document_types'] = $document_types;
        $result['provinces'] = $provinces;
        $result['industry_types'] = $industry_types;

        return $result;
    }

    public function store(CompanyCreateRequest $request)
    {
        // Iniciamos la transacción
        DB::beginTransaction();

        try {
            $company = new Company();
            $company->fill($request->only([
                'company_type_id',
                'company_name',
                'identification_type_id',
                'identification_number',
                'province_id',
                'city_id',
                'address',
                'industry_type_id',
                'size',
                'founded_at',
                'description',
                'contact_name',
                'contact_first_surname',
                'contact_second_surname',
                'website',
                'email',
                'phone',
                'cellphone',
                'facebook',
                'instagram',
                'linkedin',
                'x_twitter',
                'youtube'
            ]));

            // Uso de boolean() es más seguro para checkboxes
            $company->is_active = $request->boolean('is_active');
            $company->save();

            // Manejo del logo
            if ($request->hasFile('logo')) {
                // Pasamos la empresa por referencia o usamos su ID
                $this->uploadLogo($company, $request->file('logo'));
            }

            // Si todo salió bien, confirmamos los cambios en la BD
            DB::commit();

            return response()->json([
                'message' => '¡Empresa creada exitosamente!',
                'company' => $company->fresh(), // fresh() para traer los datos actualizados del logo
            ]);
        } catch (\Exception $e) {
            // Si algo falla, deshacemos todo lo que se hizo en la BD
            DB::rollBack();

            return response()->json([
                'message' => 'Error al crear la empresa: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function uploadLogo(Company $company, $logoFile)
    {
        // Es buena práctica envolver servicios externos en try/catch o dejar que el principal lo atrape
        $folderPath = 'mh/' . app()->environment() . '/' . $company->id . '/logo';

        $cloudinary_object = Cloudinary::upload($logoFile->getRealPath(), [
            'folder' => $folderPath
        ]);

        // Actualizamos sin disparar eventos innecesarios si fuera el caso, 
        // pero update() está bien aquí.
        $company->update([
            'logo_public_id' => $cloudinary_object->getPublicId(),
            'logo_url' => $cloudinary_object->getSecurePath(),
        ]);
    }

    public function show(Company $company)
    {
        // abort_if(Gate::denies('company_show'), 403);

        $result = [];

        $company_type = CompanyType::where('id', $company->company_type_id)->first();
        $industry_type = Industry::where('id', $company->industry_type_id)->first();
        $identification_type = DocumentType::where('id', $company->identification_type_id)->first();
        $province = Province::where('id', $company->province_id)->first();
        $city = City::where('id', $company->city_id)->first();

        $result['company'] = $company;
        $result['company_type'] = $company_type;
        $result['industry_type'] = $industry_type;
        $result['identification_type'] = $identification_type;
        $result['province'] = $province;
        $result['city'] = $city;

        return $result;
    }

    public function edit(Company $company)
    {
        // abort_if(Gate::denies('company_edit'), 403);

        $result = [];

        $company_types = CompanyType::all();
        $document_types = DocumentType::all();
        $provinces = Province::all();
        $industry_types = Industry::all();

        $result['company'] = $company;
        $result['company_types'] = $company_types;
        $result['document_types'] = $document_types;
        $result['provinces'] = $provinces;
        $result['industry_types'] = $industry_types;

        return $result;
    }

    public function update(CompanyEditRequest $request, Company $company)
    {
        DB::beginTransaction();

        try {
            // 1. Actualizar datos básicos (usando fill para ser más limpio)
            $company->fill($request->only([
                'company_name', 'company_type_id', 'identification_type_id',
                'identification_number', 'province_id', 'city_id', 'address',
                'industry_type_id', 'size', 'founded_at', 'description',
                'contact_name', 'contact_first_surname', 'contact_second_surname',
                'website', 'email', 'phone', 'cellphone', 'facebook',
                'instagram', 'linkedin', 'x_twitter', 'youtube'
            ]));

            $company->is_active = $request->boolean('is_active');
            $company->save();

            if ($request->hasFile('logo')) {
                if ($company->logo_public_id) {
                    Cloudinary::destroy($company->logo_public_id);
                }

                $this->uploadLogo($company, $request->file('logo'));
            }

            DB::commit();

            return response()->json([
                'message' => 'Empresa actualizada exitosamente!',
                'company' => $company->fresh(),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        // abort_if(Gate::denies('company_destroy'), 403);

        $company = Company::find($id);

        try {
            if (isset($company['logo_public_id'])) {
                $public_id = $company['logo_public_id'];
                Cloudinary::destroy($public_id);
            }

            $company->delete();

            return response()->json([
                'message' => 'Empresa eliminada exitosamente!',
                'company' => $company
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
