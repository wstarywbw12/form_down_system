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

        // cari user di DB Sikawan
        $sikawanUser = SikawanUser::where('email', $request->email)
            ->orWhere('username', $request->email)
            ->first();

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

        // cek user berdasarkan sikawan_id
        $user = User::where('sikawan_id', $sikawanUser->id)->first();

        // cek berdasarkan name
        if (!$user) {
            $user = User::where('name', $sikawanUser->username)->first();

            if ($user) {
                $user->update([
                    'sikawan_id' => $sikawanUser->id
                ]);
            }
        }

        // jika belum ada
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
}