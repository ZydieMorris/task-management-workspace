<?php

namespace App\Models;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'project_name',
        'project_description',
        'project_severity',
        'deployment_date',

    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
