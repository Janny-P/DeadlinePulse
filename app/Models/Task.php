<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_at',
        'priority',
        'tags',
        'attachment',
        'status',
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'tags' => 'array',
    ];
}
