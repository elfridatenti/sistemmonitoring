<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect ke halaman dashboard atau halaman sebelumnya
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Tambahan: Method untuk registrasi user baru (opsional)
    // public function register(Request $request)
    // {
    //     $validated = $request->validate([
    //         'bagde' => 'required|unique:users',
    //         'nama' => 'required',
    //         'level_user' => 'required|integer',
    //         'email' => 'required|email|unique:users',
    //         'no_tlpn' => 'required',
    //         'username' => 'required|unique:users',
    //         'password' => 'required|min:6',
    //         'role' => 'required|in:admin,leader,teknisi',
    //     ]);

    //     $validated['password'] = Hash::make($validated['password']);
    //     User::create($validated);

    //     return redirect()->route('login')->with('success', 'Registrasi berhasil.');
    // }
}
