<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index()
    {
        return view('back.modules.performance.index');
    }
}
