<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index_master()
    {
        $user = auth()->user();
        $company = Company::where('id', $user->company_id)->first();
        return view('back.home', compact('company'));
    }
}
