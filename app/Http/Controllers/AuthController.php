<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->intended('/dashboard-admin')->with('success', 'Welcome Admin!');
            }
            return redirect()->intended('/dashboard-user')->with('success', 'Welcome!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle register
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users|min:3|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'No_Handphone' => 'required|numeric|digits_between:10,15',
        ]);

        $user = Users::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'No_Handphone' => $validated['No_Handphone'],
            'role' => 'user', // Default role adalah user (customer)
        ]);

        Auth::login($user);

        return redirect('/dashboard-user')->with('success', 'Akun berhasil dibuat!');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
