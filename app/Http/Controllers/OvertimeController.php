<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function index()
    {
        return view('back.tools.overtime.index');
    }
}
