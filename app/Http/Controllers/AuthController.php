<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show Register Form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|confirmed|min:6',
        ]);

$user = User::create([
    'first_name' => $request->first_name,
    'last_name'  => $request->last_name,
    'username'   => $request->username,
    'email'      => $request->email,
    'password'   => Hash::make($request->password),
    'name'       => $request->first_name . ' ' . $request->last_name, // 👈 add this
]);


        // Option: auto-login after register
        // Auth::login($user);

        // Redirect to login instead (safer UX)
        return redirect()->route('login')->with('success', 'Account created successfully! Please login.');
    }

    // Show Login Form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        // Try login with email
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        // Try login with username
        if (Auth::attempt(['username' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
