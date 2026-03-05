<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $jenisList = Jenis::orderBy('jenis')->get();

        $query = Form::with('jenis')->orderBy('id', 'desc');

        // FILTER BERDASARKAN jenis_id
        if ($request->filled('jenis_id')) {
            $query->where('jenis_id', $request->jenis_id);
        }

        // SEARCH BERDASARKAN keterangan
        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        $data = $query->get();

        return view('dashboard', compact('data', 'jenisList'));
    }

    public function download($id)
    {
        $form = Form::findOrFail($id);

        $path = 'public/' . $form->file;

        if (Storage::exists($path)) {
            return Storage::download($path);
        }

        abort(404);
    }
}