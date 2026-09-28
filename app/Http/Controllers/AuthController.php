<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =========================
    // REGISTER PAGE
    // =========================

    public function showRegister()
    {
        return view('register');
    }


    // =========================
    // REGISTER USER
    // =========================

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => 0,
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registration successful! Please login.');
    }


    // =========================
    // LOGIN PAGE
    // =========================

    public function showLogin()
    {
        return view('login');
    }


    // =========================
    // LOGIN USER
    // =========================

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {

            $request->session()->regenerate();

            // ADMIN LOGIN
            if (Auth::user()->is_admin == 1) {
                return redirect()
                    ->route('dashboard')
                    ->with('success', 'Welcome Admin!');
            }

            // NORMAL USER LOGIN
            return redirect()
                ->route('home')
                ->with('success', 'Welcome back!');
        }

        return back()
            ->withErrors([
                'email' => 'Invalid email or password.',
            ])
            ->withInput();
    }


    // =========================
    // LOGOUT
    // =========================

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}