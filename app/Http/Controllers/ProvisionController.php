<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProvisionController extends Controller
{
    public function index()
    {
        return view('back.modules.provision.index');
    }
}
