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
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'creator_id');
    }
}
