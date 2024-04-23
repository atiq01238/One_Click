<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'task_name',
        'detail',
        'creator_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'creator_id');
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

}
