<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $input = $request->email;

        // normalisasi nomor
        $normalizedInput = $this->normalizePhone($input);

        // request login ke API Sikawan
        $response = Http::post('http://192.168.10.8/sikawan-api/public/api/v2/login', [
            'username' => $normalizedInput,
            'password' => $request->password
        ]);

        if (!$response->successful()) {
            return back()->withErrors([
                'email' => 'Tidak dapat terhubung ke server Sikawan'
            ])->withInput();
        }

        $data = $response->json();

        if ($data['metaData']['code'] != "200") {
            return back()->withErrors([
                'email' => 'Username atau password salah'
            ])->withInput();
        }

        $karyawan = $data['response']['data']['karyawan'];

        $sikawanId = $karyawan['id'];
        $nama = $karyawan['nama'];

        // cek user lokal
        $user = User::where('sikawan_id', $sikawanId)->first();

        if (!$user) {

            // cek berdasarkan name (jika sebelumnya sudah ada)
            $user = User::where('name', $normalizedInput)->first();

            if ($user) {
                $user->update([
                    'sikawan_id' => $sikawanId,
                    'name' => $nama
                ]);
            }
        }

        // jika belum ada buat user baru
        if (!$user) {
            $user = User::create([
                'sikawan_id' => $sikawanId,
                'name' => $nama
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    private function normalizePhone($phone)
    {
        // hapus selain angka
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // ubah 62 menjadi 0
        if (substr($phone, 0, 2) == '62') {
            $phone = '0' . substr($phone, 2);
        }

        return $phone;
    }
}