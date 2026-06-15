<?php

namespace App\Http\Controllers\admin;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    return Inertia::render('Admin/project/Index', [
        'severity' => ['Low', 'Medium', 'High'],
        'projects' => Project::query()
        ->when($request->search, function($query) use ($request) {
            $query->where('project_name', 'like', '%' . $request->search . '%');
        })
        ->when($request->severity, function($query) use ($request) {
            $query->where('project_severity', $request->severity);
        })
        ->get(),
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:255|unique:projects,project_name',
            'project_description' => 'required|string|max:255',
            'project_severity' => 'required|string|max:255',
            'deployment_date' => 'required|date',
        ]);

        Project::create($validated);

        return back()->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
       return Inertia::render('Admin/project/Show', [
        'projects' => $project,
       ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function members(Project $project)
    {
        return Inertia::render('Admin/project/tabs/Members', [
            'projects' => $project,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with('success', 'Project deleted successfully.');
    }
}
