<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollaboratorContractCreateRequest;
use App\Http\Requests\CollaboratorContractEditRequest;
use App\Models\AfpType;
use App\Models\ArlType;
use App\Models\BankType;
use App\Models\CcfType;
use App\Models\Collaborator;
use App\Models\CollaboratorContract;
use App\Models\Company;
use App\Models\ContractType;
use App\Models\EpsType;
use App\Models\Position;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function getContractualInformation()
    {
        $results = [];

        $position_types = Position::all();
        $contract_types = ContractType::all();
        $bank_types = BankType::all();
        $eps_types = EpsType::all();
        $arl_types = ArlType::all();
        $afp_types = AfpType::all();
        $ccf_types = CcfType::all();

        $results['position_types'] = $position_types;
        $results['contract_types'] = $contract_types;
        $results['bank_types'] = $bank_types;
        $results['eps_types'] = $eps_types;
        $results['arl_types'] = $arl_types;
        $results['afp_types'] = $afp_types;
        $results['ccf_types'] = $ccf_types;

        return $results;
    }

    public function getContracts($id)
    {
        $results = [];

        $collaborator = Collaborator::findOrFail($id);
        $contracts = $collaborator->contracts()
            ->with([
                'position',
                'contractType',
                'bank',
                'eps',
                'afpPension',
                'afpSaving',
                'arl',
                'ccf',
            ])
            ->orderByDesc('contract_start_date')
            ->get();

        $on = Carbon::today();
        $contracts->each(function ($contract) use ($on) {
            $contract->status = $contract->isActive($on) ? 'Vigente' : 'No vigente';
        });

        if ($contracts->isNotEmpty()) {
            $results['contracts'] = $contracts;
        } else {
            $results['contracts'] = [];
        }

        return $results;
    }

    public function store(CollaboratorContractCreateRequest $request, $id)
    {
        // Las validaciones se realizan en CollaboratorContractCreateRequest

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
            // 'corporate_email' => $request->corporate_email,
            // 'corporate_cellphone' => $request->corporate_cellphone,
            // 'bank_id' => $request->bank_id,
            // 'bank_account' => $request->bank_account,
            // 'eps_id' => $request->eps_id,
            // 'afp_pension_id' => $request->afp_pension_id,
            // 'afp_saving_id' => $request->afp_saving_id,
            // 'arl_id' => $request->arl_id,
            // 'ccf_id' => $request->ccf_id,
        );

        $contract = CollaboratorContract::create($data);

        return response()->json([
            'message' => 'Contrato creado exitosamente!',
            'contract' => $contract
        ]);
    }

    public function update(CollaboratorContractEditRequest $request, $id)
    {
        // Las validaciones se realizan en CollaboratorContractEditRequest

        try {
            // $collaborator_contract = CollaboratorContract::where('collaborator_id', $id)->first();
            $contract = CollaboratorContract::findOrFail($id);

            $data = array(
                // 'collaborator_id' => $id,
                'position_id' => $request->position_id,
                'salary' => $request->salary,
                'contract_type_id' => $request->contract_type_id,
                'contract_start_date' => $request->contract_start_date,
                'contract_end_date' => $request->contract_end_date,
                'test_period_end_date' => $request->test_period_end_date,
                'corporate_email' => $request->corporate_email,
                'corporate_cellphone' => $request->corporate_cellphone,
                'bank_id' => $request->bank_id,
                'bank_account' => $request->bank_account,
                'eps_id' => $request->eps_id,
                'afp_pension_id' => $request->afp_pension_id,
                'afp_saving_id' => $request->afp_saving_id,
                'arl_id' => $request->arl_id,
                'ccf_id' => $request->ccf_id,
            );

            $contract->update($data);

            return response()->json([
                'message' => 'Contrato actualizado exitosamente!',
                'contract' => $contract
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $contract = CollaboratorContract::findOrFail($id);
            $contract->delete();

            return response()->json([
                'message' => 'Contrato eliminado exitosamente!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
