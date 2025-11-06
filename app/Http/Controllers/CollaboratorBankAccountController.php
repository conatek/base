<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\BankType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CollaboratorBankAccount;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Requests\CollaboratorBankAccountEditRequest;
use App\Http\Requests\CollaboratorBankAccountCreateRequest;

class CollaboratorBankAccountController extends Controller
{
    public function getBankAccountInformation()
    {
        $results = [];

        $bank_types = BankType::all();

        $results['bank_types'] = $bank_types;

        return $results;
    }

    public function getBankAccountByCollaborator($collaborator_id)
    {
        $results = [];

        $bank_account = CollaboratorBankAccount::where('collaborator_id', $collaborator_id)
            ->with(['bank'])
            ->first();

        if ($bank_account) {
            $results['bank_account'] = $bank_account;
        } else {
            $results['bank_account'] = null;
        }

        return $results;
    }

    public function store(CollaboratorBankAccountCreateRequest $request)
    {
        // Las validaciones se realizan en CollaboratorBankAccountCreateRequest

        try{
            $company_id = Auth::user()->company_id;

            if($request->hasFile('bank_account_file')) {
                $file = request()->file('bank_account_file');

                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' =>  'mh/' . env("APP_ENV", "local") . '/' . $company_id . '/collaborators/social_securities']);
                $bank_certificate_public_id = $cloudinary_object->getPublicId();
                $bank_certificate_url = $cloudinary_object->getSecurePath();

                $data = array(
                    'collaborator_id' => $request->collaborator_id,
                    'bank_id' => $request->bank_id,
                    'bank_account' => $request->bank_account,
                    'bank_certificate_public_id' => $bank_certificate_public_id,
                    'bank_certificate_url' => $bank_certificate_url,
                    'observations' => $request->observations
                );
            } else {
                $data = array(
                    'collaborator_id' => $request->collaborator_id,
                    'bank_id' => $request->bank_id,
                    'bank_account' => $request->bank_account,
                    'observations' => $request->observations
                );
            }

            CollaboratorBankAccount::create($data);

            return response()->json([
                'message'=>'Información de cuenta bancaria ingresada exitosamente!',
                'bank_information_data'=>$data,
            ]);
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(CollaboratorBankAccountEditRequest $request, $bank_account_id)
    {
        // Las validaciones se realizan en CollaboratorBankAccountEditRequest

        try {
            $company_id = Auth::user()->company_id;

            $bank_account = CollaboratorBankAccount::where('id', $bank_account_id)->first();

            $data = array(
                'collaborator_id' => $request->collaborator_id,
                'bank_id' => $request->bank_id,
                'bank_account' => $request->bank_account,
                'observations' => $request->observations
            );

            if($request->hasFile('bank_account_file')) {
                if(isset($bank_account['bank_certificate_public_id'])) {
                    $public_id = $bank_account['bank_certificate_public_id'];
                    Cloudinary::destroy($public_id);
                }
                $file = request()->file('bank_account_file');
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' =>  'mh/' . env("APP_ENV", "local") . '/' . $company_id . '/collaborators/social_securities']);
                $bank_certificate_public_id = $cloudinary_object->getPublicId();
                $bank_certificate_url = $cloudinary_object->getSecurePath();

                $data['bank_certificate_public_id'] = $bank_certificate_public_id;
                $data['bank_certificate_url'] = $bank_certificate_url;
            }

            $bank_account->update($data);

            return response()->json([
                'message'=>'Información de cuenta bancaria actualizada exitosamente!',
                'bank_information_data'=>$data,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function downloadCertificate($bank_account_id) {
        try {
            $bank_account = CollaboratorBankAccount::where('id', $bank_account_id)->first();
            $certificate_download_url = $bank_account->bank_certificate_url;

            return response()->json([
                'certificate_download_url' => $certificate_download_url
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($bank_account_id)
    {
        // abort_if(Gate::denies('collaborator_destroy'), 403);

        try {
            $bank_account = CollaboratorBankAccount::where('id', $bank_account_id)->first();
            if(isset($bank_account['bank_certificate_public_id'])) {
                $public_id = $bank_account['bank_certificate_public_id'];
                Cloudinary::destroy($public_id);
            }

            $bank_account->delete();

            return response()->json([
                'message'=>'Cuenta bancaria eliminada exitosamente!',
                'bank_account'=>$bank_account
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
