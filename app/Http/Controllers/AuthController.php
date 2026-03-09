<?php

namespace App\Http\Controllers;

use App\Models\SikawanUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $input = $request->email;

        // normalisasi nomor yang diinput user
        $normalizedInput = $this->normalizePhone($input);

        // cari user sikawan
        $sikawanUsers = SikawanUser::all();

        $sikawanUser = $sikawanUsers->first(function ($user) use ($normalizedInput, $input) {

            // cek email
            if ($user->email === $input) {
                return true;
            }

            // normalisasi username dari database
            $normalizedDb = $this->normalizePhone($user->username);

            return $normalizedDb === $normalizedInput;
        });

        if (!$sikawanUser) {
            return back()
                ->withErrors(['email' => 'User tidak ditemukan di sistem Sikawan'])
                ->withInput();
        }

        // cek password
        if (!Hash::check($request->password, $sikawanUser->password)) {
            return back()
                ->withErrors(['password' => 'Password salah'])
                ->withInput();
        }

        // cek user lokal berdasarkan sikawan_id
        $user = User::where('sikawan_id', $sikawanUser->id)->first();

        if (!$user) {

            $user = User::where('name', $sikawanUser->username)->first();

            if ($user) {
                $user->update([
                    'sikawan_id' => $sikawanUser->id
                ]);
            }
        }

        if (!$user) {
            $user = User::create([
                'sikawan_id' => $sikawanUser->id,
                'name' => $sikawanUser->username,
                'email' => $sikawanUser->email,
                'password' => $sikawanUser->password,
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }


    private function normalizePhone($phone)
    {
        // hapus semua selain angka
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // ubah +62 atau 62 menjadi 0
        if (substr($phone, 0, 2) == '62') {
            $phone = '0' . substr($phone, 2);
        }

        return $phone;
    }
}