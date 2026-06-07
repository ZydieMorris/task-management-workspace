<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Inertia\Inertia;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use App\Models\Task;
class TaskController extends Controller
{
    public function index(Project $project)
    {
        return Inertia::render('Admin/project/tabs/Task', [
            'projects' => $project,
            'statuses' => TaskStatus::values(),
            'priorities' => TaskPriority::values(),
            'tasks' => Task::where('project_id', $project->id)->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'assign_to' => 'required|exists:users,id',
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'task_status' => 'required|in:' . implode(',', TaskStatus::values()),
            'task_priority' => 'required|in:' . implode(',', TaskPriority::values()),
            'task_deadline' => 'required|date',
        ]);

        Task::create($validated);

        return back();
    }
}
