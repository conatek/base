<?php

namespace App\Http\Controllers;

use App\Models\AfpType;
use App\Models\ArlType;
use App\Models\CcfType;
use App\Models\EpsType;
use Illuminate\Http\Request;

class CollaboratorSocialSecurityController extends Controller
{
    public function getSocialSecurityInformation()
    {
        $results = [];

        $eps_types = EpsType::all();
        $arl_types = ArlType::all();
        $afp_types = AfpType::all();
        $ccf_types = CcfType::all();

        $results['eps_types'] = $eps_types;
        $results['arl_types'] = $arl_types;
        $results['afp_types'] = $afp_types;
        $results['ccf_types'] = $ccf_types;

        return $results;
    }

    // public function store(CollaboratorSocialSecurityCreateRequest $request, $id)
    public function store(Request $request, $id)
    {
        // Las validaciones se realizan en CollaboratorSocialSecurityCreateRequest

        // $user = Auth::user();
        // $company = Company::where('id', $user->company_id)->first();

        $data = array(
            'collaborator_id' => $id,
            'position_id' => $request->position_id,
            'salary' => $request->salary,
            'contract_type_id' => $request->contract_type_id,
            'contract_start_date' => $request->contract_start_date,
            'contract_end_date' => $request->contract_end_date,
            'test_period_end_date' => $request->test_period_end_date,
            'observations' => $request->observations,
        );

        $contract = CollaboratorContract::create($data);

        return response()->json([
            'message' => 'Contrato creado exitosamente!',
            'contract' => $contract
        ]);
    }
}
