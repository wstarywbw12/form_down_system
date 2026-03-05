<?php

namespace App\Http\Controllers;

use App\Models\Form;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Form::with('jenis')->orderBy('id', 'desc')->get();

        return view('dashboard', compact('data'));
    }
}
