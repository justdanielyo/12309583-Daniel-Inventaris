<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau Password salah!'])->withInput();
    }
    public function logout(Request $request)
    {
        Auth::logout();

        // Menghapus session agar aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Kamu sudah logout');
    }
}
