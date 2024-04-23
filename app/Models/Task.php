<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'task_name',
        'description',
        'start_date',
        'end_date',
        'user_id',
        'status',
        'attachment',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function reportedTask()
    // {
    //     return $this->hasOne(ReportedTask::class);
    // }
    const STATUS_PENDING = 'tode';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'done';
}
