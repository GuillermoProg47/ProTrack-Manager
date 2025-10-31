<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('created_at','desc')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Project::create($data);
        return Redirect::route('admin.projects.index')->with('success', 'Proyecto creado');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $project->update($data);
        return Redirect::route('admin.projects.index')->with('success', 'Proyecto actualizado');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return Redirect::route('admin.projects.index')->with('success', 'Proyecto eliminado');
    }
}
