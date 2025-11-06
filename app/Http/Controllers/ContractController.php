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

        $results['position_types'] = $position_types;
        $results['contract_types'] = $contract_types;

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
