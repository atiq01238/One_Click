<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'description',
        'start_date',
        'end_date',
        'assign_user',
        'attachment',
    ];

    public function assignUser()
    {
        return $this->belongsToMany(User::class, 'assign_user');
    }
}
