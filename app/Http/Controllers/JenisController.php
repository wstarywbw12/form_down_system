<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index()
    {
        $data = Jenis::orderBy('id', 'desc')->get();
        return view('pages.jenis.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string|max:255|unique:jenis,jenis'
        ]);

        Jenis::create([
            'jenis' => $request->jenis
        ]);

        return redirect()->route('jenis.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|string|max:255|unique:jenis,jenis,' . $id
        ]);

        $jenis = Jenis::findOrFail($id);

        $jenis->update([
            'jenis' => $request->jenis
        ]);

        return redirect()->route('jenis.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jenis = Jenis::findOrFail($id);
        $jenis->delete();

        return redirect()->route('jenis.index')
            ->with('success', 'Data berhasil dihapus');
    }
}