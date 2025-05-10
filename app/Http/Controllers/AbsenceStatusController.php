<?php

namespace App\Http\Controllers;

use App\Models\AbsenceStatus;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Illuminate\Http\Request;

class AbsenceStatusController extends Controller
{
    public function update(Request $request, $absenceStatusId)
    {
        $absenceStatus = AbsenceStatus::find($absenceStatusId);
        $company_id = auth()->user()->company_id;

        if (!$absenceStatus) {
            return response()->json([
                'message' => 'Estado de ausencia no encontrado',
            ], 404);
        }

        // Validate the request data
        // $validatedData = $request->validate([
        //     'absence_id' => 'sometimes|required|exists:absences,id',
        //     'absence_status_type_id' => 'sometimes|required|exists:absence_status_types,id',
        //     'authorized_value' => 'sometimes|nullable|integer',
        //     'paid_value' => 'sometimes|nullable|integer',
        //     'payment_date' => 'sometimes|nullable|date',
        //     'report_public_id' => 'sometimes|nullable|string|max:255',
        //     'report_url' => 'sometimes|nullable|string|max:255',
        //     'observations' => 'sometimes|nullable|string|max:255',
        // ]);

        $data = $request->only([
            'absence_id',
            'absence_status_type_id',
            'authorized_value',
            'paid_value',
            'paid_days',
            'payment_date',
            'observations'
        ]);

        $url = isset($absenceStatus['support_url']) ? $absenceStatus['support_url'] : null;
        $public_id = isset($absenceStatus['support_public_id']) ? $absenceStatus['support_public_id'] : null;

        if($request->hasFile('support_file')) {
            if($public_id != null) {
                Cloudinary::destroy($public_id);
            }
            $file = request()->file('support_file');
            $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' =>  'mh/' . env("APP_ENV", "local") . '/' . $company_id . '/absences/support']);
            $support_public_id = $cloudinary_object->getPublicId();
            $support_url = $cloudinary_object->getSecurePath();

            $data['support_public_id'] = $support_public_id;
            $data['support_url'] = $support_url;
        } else {
            $data['support_public_id'] = $public_id;
            $data['support_url'] = $url;
        }

        $absenceStatus->update($data);

        return response()->json([
            'message'=>'Estado de ausencia actualizado exitosamente!',
            'absenceStatus'=>$absenceStatus
        ]);
    }

    public function downloadAbsenceSupport($absence_id) {
        try {
            $absenceStatus = AbsenceStatus::where('absence_id', $absence_id)->first();
            $support_download_url = $absenceStatus->support_url;

            return response()->json([
                'support_download_url' => $support_download_url
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
