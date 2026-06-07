<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
           $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assign_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('task_name');
            $table->text('task_description')->nullable();
            $table->string('task_status')->default(TaskStatus::ToDo->value);
            $table->string('task_priority')->default(TaskPriority::Medium->value);
            $table->date('task_deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
