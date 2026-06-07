<?php

namespace App\Models;
use App\Models\Project;
use App\Models\User;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'assign_to',
        'task_name',
        'task_description',
        'task_status',
        'task_priority',
        'task_deadline',
    ];

    protected $casts = [
        'task_status' => TaskStatus::class,
        'task_priority' => TaskPriority::class,
        'task_deadline' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }
}
