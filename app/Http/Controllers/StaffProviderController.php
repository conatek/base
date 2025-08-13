<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffProviderCreateRequest;
use App\Http\Requests\StaffProviderEditRequest;
use App\Models\ProviderType;
use App\Models\Province;
use App\Models\StaffProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffProviderController extends Controller
{
    public function index()
    {
        $provider_types = ProviderType::all();
        // $provider_types = ProviderType::where('id', '!=', 1)->get();
        $provinces = Province::all();
        $company_id = Auth::user()->company_id;

        return view('back.staff_providers.index', compact('company_id', 'provinces', 'provider_types'));
    }

    public function getProvidersData($company_id)
    {
        $providers = StaffProvider::where('company_id', $company_id)->with('providerType')->get();

        return response()->json([
            'providers' => $providers,
        ]);
    }

    public function store(StaffProviderCreateRequest $request)
    {
        $provider = StaffProvider::create([
            'company_id' => $request->company_id,
            'name' => $request->name,
            'provider_type_id' => $request->provider_type_id,
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_cellphone' => $request->contact_cellphone,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'website' => $request->website,
            'observations' => $request->observations,
        ]);

        return response()->json([
            'message' => 'Proveedor creado exitosamente.',
            'provider' => $provider,
        ]);
    }

    public function update(StaffProviderEditRequest $request, StaffProvider $provider)
    {
        $provider->update($request->all());

        return response()->json([
            'message' => 'Proveedor actualizado exitosamente.',
            'provider' => $provider,
        ]);
    }

    public function destroy(StaffProvider $provider)
    {
        $provider->delete();

        return response()->json([
            'message' => 'Proveedor eliminado exitosamente.',
        ]);
    }
}
