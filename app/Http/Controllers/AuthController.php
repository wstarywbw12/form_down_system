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

        // cek user di DB Sikawan
        $sikawanUser = SikawanUser::where('email', $request->email)
            ->orWhere('username', $request->email)
            ->first();

        if (! $sikawanUser) {
            return back()->with('error', 'User tidak ditemukan di sistem Sikawan');
        }

        // cek password
        if (! Hash::check($request->password, $sikawanUser->password)) {
            return back()->with('error', 'Password salah');
        }

        // cek apakah user sudah ada di DB Form
        $user = User::where('email', $sikawanUser->email)->first();

        if (! $user) {
            // jika belum ada maka buat otomatis
            $user = User::create([
                'name' => $sikawanUser->username,
                'email' => $sikawanUser->email,
                'password' => $sikawanUser->password,
            ]);
        }

        // login ke aplikasi form
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
