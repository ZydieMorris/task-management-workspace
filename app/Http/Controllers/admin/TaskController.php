<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $task = Task::where('project_id', $project->id)->get();
        $grouped = $task->groupBy(fn($task) => $task->task_status->value);

        return Inertia::render('Admin/project/tabs/Task', [
            'projects' => $project,
            'statuses'   => collect(TaskStatus::values())->map(fn($status) => [
                'name'  => $status,
                'tasks' => $grouped->get($status, collect())->values(),
            ]),
            'priorities' => TaskPriority::values(),
            'users' => User::all(['id', 'name']),
        ]);
    }


    public function create()
    {
        //
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'assign_to' => 'nullable|exists:users,id',
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'task_status' => 'required|string|in:' . implode(',', TaskStatus::values()),
            'task_priority' => 'required|string|in:' . implode(',', TaskPriority::values()),
            'task_deadline' => 'nullable|date',
        ]);

        $validated['project_id'] = $project->id;

        Task::create($validated);

        return back()->with('success', 'Task created successfully.');
    }

    public function show(Project $project, Task $task)
    {
        //
    }

    public function edit(Project $project, Task $task)
    {
        //
    }

    public function update(Request $request, Project $project, Task $task)
    {
        $validated = $request->validate([
            'assign_to' => 'nullable|exists:users,id',
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'task_status' => 'required|string|in:' . implode(',', TaskStatus::values()),
            'task_priority' => 'required|string|in:' . implode(',', TaskPriority::values()),
            'task_deadline' => 'nullable|date',
        ]);

        $task->update($validated);

        return back()->with('success', 'Task updated successfully.');
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return back()->with('success', 'Task deleted successfully.');
    }
}
