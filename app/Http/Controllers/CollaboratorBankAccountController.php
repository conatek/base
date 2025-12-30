<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\BankType;
use App\Models\BankAccountType;
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

        $results['bank_types'] = BankType::all();
        $results['bank_account_types'] = BankAccountType::all();

        return $results;
    }

    public function getBankAccountByCollaborator($collaborator_id)
    {
        $results = [];

        $bank_account = CollaboratorBankAccount::where('collaborator_id', $collaborator_id)
            ->with(['bank', 'accountType'])
            ->first();

        $results['bank_account'] = $bank_account ?: null;

        return $results;
    }

    public function store(CollaboratorBankAccountCreateRequest $request)
    {
        try {
            $company_id = Auth::user()->company_id;
            
            // Preparamos los datos base incluyendo el nuevo ID
            $data = [
                'collaborator_id'      => $request->collaborator_id,
                'bank_id'              => $request->bank_id,
                'bank_account_type_id' => $request->bank_account_type_id, // Nuevo campo
                'bank_account'         => $request->bank_account,
            ];

            if ($request->hasFile('bank_account_file')) {
                $file = $request->file('bank_account_file');
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), [
                    'folder' => 'mh/' . env("APP_ENV", "local") . '/' . $company_id . '/collaborators/social_securities'
                ]);
                
                $data['bank_certificate_public_id'] = $cloudinary_object->getPublicId();
                $data['bank_certificate_url']       = $cloudinary_object->getSecurePath();
            }

            CollaboratorBankAccount::create($data);

            return response()->json([
                'message' => 'Información de cuenta bancaria ingresada exitosamente!',
                'bank_information_data' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(CollaboratorBankAccountEditRequest $request, $bank_account_id)
    {
        try {
            $company_id = Auth::user()->company_id;
            $bank_account = CollaboratorBankAccount::findOrFail($bank_account_id);

            $data = [
                'collaborator_id'      => $request->collaborator_id,
                'bank_id'              => $request->bank_id,
                'bank_account_type_id' => $request->bank_account_type_id, // Nuevo campo
                'bank_account'         => $request->bank_account,
            ];

            if ($request->hasFile('bank_account_file')) {
                // Eliminar certificado anterior si existe
                if (!empty($bank_account->bank_certificate_public_id)) {
                    Cloudinary::destroy($bank_account->bank_certificate_public_id);
                }

                $file = $request->file('bank_account_file');
                $cloudinary_object = Cloudinary::upload($file->getRealPath(), [
                    'folder' => 'mh/' . env("APP_ENV", "local") . '/' . $company_id . '/collaborators/social_securities'
                ]);

                $data['bank_certificate_public_id'] = $cloudinary_object->getPublicId();
                $data['bank_certificate_url']       = $cloudinary_object->getSecurePath();
            }

            $bank_account->update($data);

            return response()->json([
                'message' => 'Información de cuenta bancaria actualizada exitosamente!',
                'bank_information_data' => $bank_account->load(['bank', 'accountType']), // Recargamos con relaciones
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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
