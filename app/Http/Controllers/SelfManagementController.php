<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelfManagementController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name')->toArray();

        return view('back.self_management.profile', compact('user', 'roles'));
    }


}
