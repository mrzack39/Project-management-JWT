<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Create a new project
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'department' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required',
        ]);

        $project = Project::create($request->all());

        return response()->json($project, 201);
    }

    // Read all projects
    public function index()
    {
        return Project::all();
    }

    // Read a single project
    public function show($id)
    {
        return Project::findOrFail($id);
    }

    // Update a project
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());

        return response()->json($project, 200);
    }

    // Delete a project
    public function destroy($id)
    {
        Project::destroy($id);

        return response()->json(null, 204);
    }
}
