<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    // Admin: list all tasks
    public function index()
    {
        $tasks = Task::with(['assigned','creator'])->orderBy('created_at','desc')->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    // Admin: form to create
    public function create()
    {
        $workers = User::where('role','worker')->get();
        return view('admin.tasks.create', compact('workers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);
        // If assigned_to provided, ensure the user is a worker
        if (!empty($data['assigned_to'])) {
            $assignee = User::find($data['assigned_to']);
            if (!$assignee || ($assignee->role ?? 'user') !== 'worker') {
                return Redirect::back()->withErrors(['assigned_to' => 'El usuario asignado debe ser un trabajador.'])->withInput();
            }
        }
        $data['created_by'] = session('user.id') ?? null;
        Task::create($data + ['status' => 'pending']);
        return Redirect::route('admin.tasks.index')->with('success','Task created');
    }

    public function edit(Task $task)
    {
        $workers = User::where('role','worker')->get();
        return view('admin.tasks.edit', compact('task','workers'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'status' => 'nullable|string',
        ]);
        // Ensure assigned user (if any) is a worker
        if (!empty($data['assigned_to'])) {
            $assignee = User::find($data['assigned_to']);
            if (!$assignee || ($assignee->role ?? 'user') !== 'worker') {
                return Redirect::back()->withErrors(['assigned_to' => 'El usuario asignado debe ser un trabajador.'])->withInput();
            }
        }
        $task->update($data);
        return Redirect::route('admin.tasks.index')->with('success','Task updated');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return Redirect::route('admin.tasks.index')->with('success','Task deleted');
    }

    // Worker: list own tasks
    public function myTasks()
    {
        $userId = session('user.id') ?? null;
        $tasks = Task::where('assigned_to', $userId)->orderBy('due_date')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function markComplete(Task $task)
    {
        $userId = session('user.id') ?? null;
        if ($task->assigned_to != $userId) {
            abort(403);
        }
        $task->update(['status' => 'done']);
        return Redirect::back()->with('success','Task marked complete');
    }
}
