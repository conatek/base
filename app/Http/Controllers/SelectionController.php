<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Campus;
use App\Models\Collaborator;
use App\Models\CollaboratorRequisitionType;
use App\Models\Position;
use App\Models\SelectionSource;
use App\Models\VacancyReason;
use App\Models\VacancyStatus;
use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function index()
    {
        $company_id = auth()->user()->company_id;

        $collaborators = Collaborator::where('company_id', $company_id)->get();
        $campuses = Campus::where('company_id', $company_id)->get();
        $areas = Area::where('company_id', $company_id)->get();
        $positions = Position::where('company_id', $company_id)->get();
        $reasons = VacancyReason::all();
        $statuses = VacancyStatus::all();
        $sources = SelectionSource::all();

        $requisition_types = CollaboratorRequisitionType::all();


        return view('back.modules.selection.index', compact('requisition_types', 'collaborators', 'campuses', 'areas', 'positions', 'reasons', 'statuses', 'sources'));
    }
}
