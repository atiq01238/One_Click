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
        'user_id',
        'attachment',
    ];

    public function user()
        {
            return $this->belongsTo(User::class);
        }

    // public function creator()
    // {
    //     return $this->belongsTo(User::class);
    // }
    // public function creator()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}
