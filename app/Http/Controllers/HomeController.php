<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('can:home_index')->only(['index']);
    }

    public function index()
    {
        $user = Auth::user();
        $company = Company::where('id', $user->company_id)->first();
        $roles = $user->roles->pluck('name')->toArray();

        return view('back.home.home', compact('user', 'company', 'roles'));
    }
}
