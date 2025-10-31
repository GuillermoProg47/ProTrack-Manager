<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Try to authenticate against users table first
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $request->session()->put('user', [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->role ?? 'user',
            ]);
            return Redirect::intended(route('home'));
        }

        // Fallback: demo credentials for quick testing
        $demoEmail = config('app.demo_user_email', 'admin@example.com');
        $demoPass = config('app.demo_user_password', 'password');

        if ($request->email === $demoEmail && $request->password === $demoPass) {
            $request->session()->put('user', [
                'email' => $demoEmail,
                'name' => 'Demo Admin',
                'role' => 'user',
            ]);
            return Redirect::intended(route('home'));
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // For security, registrations from public form always get 'user' role.
        // Admin accounts should be created by an existing admin in the admin panel.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // Log in the new user into session
        $request->session()->put('user', [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'role' => $user->role,
        ]);

        return Redirect::intended(route('home'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('login.form');
    }
}
