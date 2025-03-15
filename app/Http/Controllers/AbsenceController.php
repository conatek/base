<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\AbsenceType;
use Illuminate\Http\Request;
use App\Models\AbsenceSubtype;
use App\Models\Campus;
use App\Models\DiseaseClassification;
use App\Models\Eps;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Illuminate\Validation\Rule;

class AbsenceController extends Controller
{
    public function index()
    {
        $eps = Eps::all();
        $campuses = Campus::all();
        $absence_types = AbsenceType::all();
        $absence_subtypes = AbsenceSubtype::all();

        return view('back.modules.absence.index', compact('eps', 'campuses', 'absence_types', 'absence_subtypes'));
    }

    public function getAbsences()
    {
        $company_id = auth()->user()->company_id;

        $absences = Absence::from('absences as ab')
            ->join('collaborators as c', 'c.id', '=', 'ab.collaborator_id')
            ->join('companies as cp', 'cp.id', '=', 'c.company_id')
            ->join('collaborator_contracts as cc', 'cc.collaborator_id', '=', 'c.id')
            ->join('positions as p', 'p.id', '=', 'cc.position_id')
            ->join('areas as a', 'a.id', '=', 'p.area_id')
            ->join('campuses as cmp', 'cmp.id', '=', 'a.campus_id')
            ->where('cp.id', $company_id)
            ->select('ab.*', 'a.id as area_id', 'cmp.id as campus_id')
            ->with([
                'collaborator',
                'collaboratorContract',
                'absenceType',
                'segment'
            ])
            ->get();

        return ['absences' => $absences->toArray()];
    }

    public function getDiseaseClassificationByCode($code)
    {
        $disease_classification = DiseaseClassification::where('cie_code', $code)->first();

        if (!$disease_classification) {
            return ['disease_classification' => []];
        }

        return ['disease_classification' => $disease_classification->toArray()];
    }

    public function getAbsencesByCollaborator($collaborator_id)
    {
        $absences = Absence::where('collaborator_id', $collaborator_id)->orderBy('id', 'desc')->with('collaborator', 'collaboratorContract', 'absenceType', 'segment')->get();

        return ['absences' => $absences->toArray()];
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'absence_type_id' => 'required',
        //     'description' => 'required',
        //     'start_date' => 'required|date|before_or_equal:end_date|after_or_equal:today',
        //     'end_date' => 'required|date|after_or_equal:start_date',
        //     'disease_classification_id' => 'required',
        //     'hours' => 'required',
        //     'days' => 'required',
        // ]);

        // if (in_array($request->absence_type_id, [6, 7, 8])) {
        //     $request->validate([
        //         'absence_subtype' => 'required',
        //     ]);
        // } else {
        //     $request->validate([
        //         'disease_classification_code' => 'required',
        //     ]);
        // }

        // if ($request->is_extension) {
        //     $request->validate([
        //         'parent_absence_id' => 'required',
        //     ]);
        // }

        // dd($request->is_extension);

        $rules = [
            'absence_type_id' => 'required',
            'description' => 'required|string|max:255',
            // 'start_date' => 'required|date|before_or_equal:end_date|after_or_equal:today',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'hours' => 'required|numeric|min:0',
            'days' => 'required|numeric|min:0',
            'observations' => 'nullable|string|max:1000',
            'support_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
        ];

        // Reglas condicionales para tipos de ausencia 6, 7, 8
        if (in_array($request->absence_type_id, [6, 7, 8])) {
            $rules['absence_subtype'] = 'required';
        } else {
            $rules['disease_classification_code'] = 'required';
        }

        // Reglas para extensiones
        if ($request->boolean('is_extension')) {
            $rules['parent_absence_id'] = [
                'required',
                'exists:absences,id',
                Rule::unique('absences', 'parent_absence_id')
                    ->where(function ($query) use ($request) {
                        return $query->where('collaborator_id', $request->collaborator_id);
                    }),
            ];
        }

        $validatedData = $request->validate($rules, [
            // General
            'absence_type_id.required' => 'El tipo de contingencia es obligatorio.',

            'description.required' => 'La descripción es requerida.',
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no debe superar los 255 caracteres.',

            'start_date.required' => 'La fecha de inicio es requerida.',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'start_date.before_or_equal' => 'La fecha de inicio debe ser igual o anterior a la fecha de finalización.',
            // 'start_date.after_or_equal' => 'La fecha de inicio debe ser igual o posterior a hoy.',

            'end_date.required' => 'La fecha de finalización es requerida.',
            'end_date.date' => 'La fecha de finalización debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.',

            'hours.required' => 'Las horas son requeridas.',
            'hours.numeric' => 'Las horas deben ser un número válido.',
            'hours.min' => 'Las horas no pueden ser un valor negativo.',

            'days.required' => 'Los días son requeridos.',
            'days.numeric' => 'Los días deben ser un número válido.',
            'days.min' => 'Los días no pueden ser un valor negativo.',

            'observations.string' => 'Las observaciones deben ser un texto válido.',
            'observations.max' => 'Las observaciones no deben superar los 1000 caracteres.',

            'support_file.file' => 'El archivo de soporte debe ser un archivo válido.',
            'support_file.mimes' => 'El archivo de soporte debe ser de tipo: pdf, doc, docx, jpg, jpeg o png.',
            'support_file.max' => 'El archivo de soporte no debe ser mayor a 5MB.',

            // Reglas condicionales: absence_type_id 6, 7, 8
            'absence_subtype.required' => 'El subtipo de contingencia es obligatorio.',

            // Reglas condicionales: otros tipos de ausencia
            'disease_classification_code.required' => 'El código CIE es obligatorio.',

            // Reglas para extensiones
            'parent_absence_id.required' => 'La ausencia padre es requerida.',
            'parent_absence_id.exists' => 'La ausencia padre seleccionada no existe.',
            'parent_absence_id.unique' => 'Esta ausencia ya tiene una prórroga registrada.',
        ]);

        try {
            $company_id = auth()->user()->company_id;

            $is_extension = 0;
            if ($request->boolean('is_extension')) {
                $is_extension = 1;
            }

            if($request->hasFile('support_file')) {
                $file = request()->file('support_file');

                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' =>  'mh/' . env("APP_ENV", "local") . '/' . $company_id . '/absences']); // => mh/local/1/absences/39/qxrcxytjrwufqjij9ix3
                $support_file_public_id = $cloudinary_object->getPublicId();
                $support_file_url = $cloudinary_object->getSecurePath();

                $data = array(
                    'collaborator_id' => $request->collaborator_id,
                    'is_extension' => $is_extension,
                    'parent_absence_id' => $request->parent_absence_id,
                    'absence_type_id' => $request->absence_type_id,
                    'absence_subtype' => $request->absence_subtype,
                    'disease_classification_code' => $request->disease_classification_code,
                    'description' => $request->description,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'hours' => $request->hours,
                    'days' => $request->days,
                    'support_file_id' => $support_file_public_id,
                    'support_file_url' => $support_file_url,
                    'observations' => $request->observations,
                );
            } else {
                $data = array(
                    'collaborator_id' => $request->collaborator_id,
                    'is_extension' => $is_extension,
                    'parent_absence_id' => $request->parent_absence_id,
                    'absence_type_id' => $request->absence_type_id,
                    'absence_subtype' => $request->absence_subtype,
                    'disease_classification_code' => $request->disease_classification_code,
                    'description' => $request->description,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'hours' => $request->hours,
                    'days' => $request->days,
                    'observations' => $request->observations,
                );
            }

            Absence::create($data);

            $absences = Absence::where('collaborator_id', $request->collaborator_id)->orderBy('id', 'desc')->with('absenceType')->get();

            return response()->json([
                'message'=>'Ausencia registrada exitosamente!',
                'absence'=>$absences
            ]);
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $collaborator_id, $absence_id)
    {
        $absence = Absence::where('collaborator_id', $collaborator_id)->find($absence_id);

        $rules = [
            'absence_type_id' => 'required',
            'description' => 'required|string|max:255',
            'start_date' => 'required|date|before_or_equal:end_date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'hours' => 'required|numeric|min:0',
            'days' => 'required|numeric|min:0',
            'observations' => 'nullable|string|max:1000',
            'support_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
        ];

        // Reglas condicionales para tipos de ausencia 6, 7, 8
        if (in_array($request->absence_type_id, [6, 7, 8])) {
            $rules['absence_subtype'] = 'required';
        } else {
            $rules['disease_classification_code'] = 'required';
        }

        // Reglas para extensiones
        if ($request->boolean('is_extension')) {
            $rules['parent_absence_id'] = [
                'required',
                'exists:absences,id',
                Rule::unique('absences', 'parent_absence_id')
                    ->where(function ($query) use ($request) {
                        return $query->where('collaborator_id', $request->collaborator_id);
                    })
                    ->ignore($absence->id),
            ];
        }

        $validatedData = $request->validate($rules, [
            // General
            'absence_type_id.required' => 'El tipo de contingencia es obligatorio.',

            'description.required' => 'La descripción es requerida.',
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no debe superar los 255 caracteres.',

            'start_date.required' => 'La fecha de inicio es requerida.',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'start_date.before_or_equal' => 'La fecha de inicio debe ser igual o anterior a la fecha de finalización.',
            'start_date.after_or_equal' => 'La fecha de inicio debe ser igual o posterior a hoy.',

            'end_date.required' => 'La fecha de finalización es requerida.',
            'end_date.date' => 'La fecha de finalización debe ser una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.',

            'hours.required' => 'Las horas son requeridas.',
            'hours.numeric' => 'Las horas deben ser un número válido.',
            'hours.min' => 'Las horas no pueden ser un valor negativo.',

            'days.required' => 'Los días son requeridos.',
            'days.numeric' => 'Los días deben ser un número válido.',
            'days.min' => 'Los días no pueden ser un valor negativo.',

            'observations.string' => 'Las observaciones deben ser un texto válido.',
            'observations.max' => 'Las observaciones no deben superar los 1000 caracteres.',

            'support_file.file' => 'El archivo de soporte debe ser un archivo válido.',
            'support_file.mimes' => 'El archivo de soporte debe ser de tipo: pdf, doc, docx, jpg, jpeg o png.',
            'support_file.max' => 'El archivo de soporte no debe ser mayor a 5MB.',

            // Reglas condicionales: absence_type_id 6, 7, 8
            'absence_subtype.required' => 'El subtipo de contingencia es obligatorio.',

            // Reglas condicionales: otros tipos de ausencia
            'disease_classification_code.required' => 'El código CIE es obligatorio.',

            // Reglas para extensiones
            'parent_absence_id.required' => 'La ausencia padre es requerida.',
            'parent_absence_id.exists' => 'La ausencia padre seleccionada no existe.',
            'parent_absence_id.unique' => 'Esta ausencia ya tiene una prórroga registrada.',
        ]);

        try {
            $company_id = auth()->user()->company_id;

            $is_extension = 0;
            if ($request->boolean('is_extension')) {
                $is_extension = 1;
            }

            $data = array(
                'collaborator_id' => $request->collaborator_id,
                'is_extension' => $is_extension,
                'parent_absence_id' => $request->parent_absence_id,
                'absence_type_id' => $request->absence_type_id,
                'absence_subtype' => $request->absence_subtype,
                'disease_classification_code' => $request->disease_classification_code,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'hours' => $request->hours,
                'days' => $request->days,
                'observations' => $request->observations,
            );

            $url = isset($absence['support_file_url']) ? $absence['support_file_url'] : null;
            $public_id = isset($absence['support_file_public_id']) ? $absence['support_file_public_id'] : null;

            if($request->hasFile('support_file')) {
                if($public_id != null) {
                    Cloudinary::destroy($public_id);
                }

                $file = request()->file('support_file');

                $cloudinary_object = Cloudinary::upload($file->getRealPath(), ['folder' =>  'mh/' . env("APP_ENV", "local") . '/' . $company_id . '/absences']); // => mh/local/1/absences/39/qxrcxytjrwufqjij9ix3
                $support_file_public_id = $cloudinary_object->getPublicId();
                $support_file_url = $cloudinary_object->getSecurePath();

                $data['support_file_public_id'] = $support_file_public_id;
                $data['support_file_url'] = $support_file_url;
            } else {
                $data['support_file_public_id'] = $public_id;
                $data['support_file_url'] = $url;
            }

            $absence->update($data);

            $absences = Absence::where('collaborator_id', $collaborator_id)->orderBy('id', 'desc')->with('absenceType')->get();

            return response()->json([
                'message'=>'Ausencia actualizada exitosamente!',
                'absence'=>$absences
            ]);
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($collaborator_id, Absence $absence)
    {
        // abort_if(Gate::denies('absence_destroy'), 403);

        try {
            if(isset($absence['support_file_public_id'])) {
                $public_id = $absence['support_file_public_id'];
                Cloudinary::destroy($public_id);
            }

            $absence->delete();

            $absences = Absence::where('collaborator_id', $collaborator_id)->orderBy('id', 'desc')->with('absenceType')->get();

            return response()->json([
                'message'=>'Registro eliminado exitosamente!',
                'absences'=>$absences
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
