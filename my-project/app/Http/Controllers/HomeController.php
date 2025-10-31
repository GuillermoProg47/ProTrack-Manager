<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Simple session-based protection: if no user in session, redirect to login form.
        if (!session()->has('user')) {
            return redirect()->route('login.form');
        }

        // Datos de ejemplo para demostración.
        $tasks = [
            ['id' => 1, 'title' => __('messages.task1'), 'status' => 'done'],
            ['id' => 2, 'title' => __('messages.task2'), 'status' => 'pending'],
            ['id' => 3, 'title' => __('messages.task3'), 'status' => 'in-progress'],
        ];

        // If the logged user is a worker, show worker dashboard
        $role = session('user.role', 'user');
        if ($role === 'worker') {
            return view('worker.dashboard');
        }

        return view('home', compact('tasks'));
    }
}
