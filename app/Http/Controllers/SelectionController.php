<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Campus;
use App\Models\Position;
use App\Models\Collaborator;
use App\Models\VacancyReason;
use App\Models\VacancyStatus;
use App\Models\SelectionSource;
use Illuminate\Support\Facades\Auth;
use App\Models\CollaboratorRequisition;
use App\Models\CollaboratorRequisitionType;

class SelectionController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;

        $collaborators = Collaborator::where('company_id', $company_id)->get();
        $campuses = Campus::where('company_id', $company_id)->get();
        $areas = Area::where('company_id', $company_id)->get();
        $positions = Position::where('company_id', $company_id)->get();
        $reasons = VacancyReason::all();
        $statuses = VacancyStatus::all();
        $sources = SelectionSource::all();
        $requisition_types = CollaboratorRequisitionType::all();

        if (request()->ajax()) {
            return response()->json(compact('requisition_types', 'collaborators', 'campuses', 'areas', 'positions', 'reasons', 'statuses', 'sources'));
        }

        return view('spa');
    }
}
