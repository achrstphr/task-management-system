<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'difficulty_level',
        'priority_level',
        'user_id',
        'task_status' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
