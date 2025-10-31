<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function index()
    {
        // Simple admin dashboard: list users and basic stats
        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact('users'));
    }

    /**
     * Show the form for editing the specified user (role).
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:user,worker,admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Update the specified user's role.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,worker,admin',
        ]);

        // Prevent changing your own role to avoid lockout
        $current = session('user');
        if ($current && $current['id'] == $user->id && $request->role !== $user->role) {
            return redirect()->back()->with('error', 'No puedes cambiar tu propio rol desde aquí.');
        }

        // If demoting an admin, ensure there is at least one other admin
        if ($user->role === 'admin' && $request->role !== 'admin') {
            $adminsCount = User::where('role', 'admin')->count();
            if ($adminsCount <= 1) {
                return redirect()->back()->with('error', 'No puedes degradar al último administrador.');
            }
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Toggle active status for a user (activate/deactivate)
     */
    public function toggleActive(User $user)
    {
        // Prevent deactivating yourself
        $current = session('user');
        if ($current && $current['id'] == $user->id) {
            return Redirect::back()->with('error', 'No puedes desactivar tu propia cuenta desde aquí.');
        }

        $user->active = ! ($user->active ?? true);
        $user->save();

        return Redirect::route('admin.dashboard')->with('success', 'Estado actualizado.');
    }

    /**
     * Reset a user's password to a secure temporary value (dev-friendly: 'secret').
     */
    public function resetPassword(User $user)
    {
        // Prevent resetting own password from here (encourage user flow)
        $current = session('user');
        if ($current && $current['id'] == $user->id) {
            return Redirect::back()->with('error', 'Usa el flujo de contraseña para cambiar tu propia contraseña.');
        }

        $user->password = Hash::make('secret');
        $user->save();

        return Redirect::route('admin.dashboard')->with('success', 'Contraseña reseteada a "secret" (cámbiala al entrar).');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $current = session('user');
        if ($current && $current['id'] == $user->id) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta desde el panel.');
        }

        // Prevent deleting the last admin account
        if ($user->role === 'admin') {
            $adminsCount = User::where('role', 'admin')->count();
            if ($adminsCount <= 1) {
                return redirect()->back()->with('error', 'No puedes eliminar al último administrador.');
            }
        }

        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Usuario eliminado.');
    }
}
