<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    public function index()
    {
        $data  = Form::with('jenis')->orderBy('id','desc')->get();
        $jenis = Jenis::orderBy('jenis')->get();

        return view('pages.forms.index', compact('data','jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_id'   => 'required|exists:jenis,id',
            'keterangan' => 'required|string|max:255',
            'file'       => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:2048'
        ]);

        $filePath = $request->file('file')->store('forms','public');

        Form::create([
            'jenis_id'   => $request->jenis_id,
            'keterangan' => $request->keterangan,
            'file'       => $filePath
        ]);

        return redirect()->route('forms.index')
            ->with('success','Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);

        $request->validate([
            'jenis_id'   => 'required|exists:jenis,id',
            'keterangan' => 'required|string|max:255',
            'file'       => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048'
        ]);

        if($request->hasFile('file')){
            if(Storage::disk('public')->exists($form->file)){
                Storage::disk('public')->delete($form->file);
            }
            $filePath = $request->file('file')->store('forms','public');
            $form->file = $filePath;
        }

        $form->update([
            'jenis_id'   => $request->jenis_id,
            'keterangan' => $request->keterangan,
            'file'       => $form->file
        ]);

        return redirect()->route('forms.index')
            ->with('success','Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $form = Form::findOrFail($id);

        if(Storage::disk('public')->exists($form->file)){
            Storage::disk('public')->delete($form->file);
        }

        $form->delete();

        return redirect()->route('forms.index')
            ->with('success','Data berhasil dihapus');
    }
}