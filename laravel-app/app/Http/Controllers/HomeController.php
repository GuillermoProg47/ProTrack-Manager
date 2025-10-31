<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Datos de ejemplo para demostración.
        $tasks = [
            ['id' => 1, 'title' => __('messages.task1'), 'status' => 'done'],
            ['id' => 2, 'title' => __('messages.task2'), 'status' => 'pending'],
            ['id' => 3, 'title' => __('messages.task3'), 'status' => 'in-progress'],
        ];

        return view('home', compact('tasks'));
    }
}
