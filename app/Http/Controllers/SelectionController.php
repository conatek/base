<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectionController extends Controller
{
    public function index()
    {
        return view('back.modules.selection.index');
    }
}
