<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Position;
use App\Models\Collaborator;
use App\Models\ContractType;
use Illuminate\Http\Request;
use App\Models\CollaboratorContract;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CollaboratorContractEditRequest;
use App\Http\Requests\CollaboratorContractCreateRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

    public function getActiveContractByCollaborator($collaborator_id)
    {
        $collaborator = Collaborator::findOrFail($collaborator_id);
        $on = Carbon::today();

        $active_contract = $collaborator->contracts()
            ->where('contract_start_date', '<=', $on)
            ->where(function ($query) use ($on) {
                $query->whereNull('contract_end_date')
                      ->orWhere('contract_end_date', '>=', $on);
            })
            ->with([
                'position',
                'contractType',
            ])
            ->orderByDesc('contract_start_date')
            ->first();

        return response()->json([
            'active_contract' => $active_contract
        ]);
    }

    public function store(CollaboratorContractCreateRequest $request, $collaborator_id)
    {
        // Las validaciones se realizan en CollaboratorContractCreateRequest

        try {
            $company_id = Auth::user()->company_id;

            $folderPath = 'mh/' . env("APP_ENV", "local") . '/' . $company_id . '/collaborators/' . $collaborator_id . '/contracts';

            $data = array(
                'collaborator_id' => $collaborator_id,
                'position_id' => $request->position_id,
                'salary' => $request->salary,
                'contract_type_id' => $request->contract_type_id,
                'contract_start_date' => $request->contract_start_date,
                'contract_end_date' => $request->contract_end_date,
                'test_period_end_date' => $request->test_period_end_date,
                'observations' => $request->observations,
            );

            if ($request->hasFile('contract_file')) {
                $file = $request->file('contract_file');
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' => $folderPath]);

                $data['contract_file_public_id'] = $cloudinary_object->getPublicId();
                $data['contract_file_url'] = $cloudinary_object->getSecurePath();
            }

            $contract = CollaboratorContract::create($data);

            return response()->json([
                'message' => 'Contrato creado exitosamente!',
                'contract' => $contract
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(CollaboratorContractEditRequest $request, $id)
    {
        // Las validaciones se realizan en CollaboratorContractEditRequest

        try {
            $company_id = Auth::user()->company_id;
            $contract = CollaboratorContract::findOrFail($id);

            $folderPath = 'mh/' . env("APP_ENV", "local") . '/' . $company_id . '/collaborators/' . $contract->collaborator_id . '/contracts';

            $data = array(
                'position_id' => $request->position_id,
                'salary' => $request->salary,
                'contract_type_id' => $request->contract_type_id,
                'contract_start_date' => $request->contract_start_date,
                'contract_end_date' => $request->contract_end_date,
                'test_period_end_date' => $request->test_period_end_date,
                'observations' => $request->observations,
            );

            if ($request->hasFile('contract_file')) {
                if ($contract->contract_file_public_id) {
                    Cloudinary::destroy($contract->contract_file_public_id);
                }

                $file = $request->file('contract_file');
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' => $folderPath]);

                $data['contract_file_public_id'] = $cloudinary_object->getPublicId();
                $data['contract_file_url'] = $cloudinary_object->getSecurePath();
            }

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
