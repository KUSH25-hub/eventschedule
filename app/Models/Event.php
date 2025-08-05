<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // ✅ This is necessary to allow mass assignment of these fields
    protected $fillable = [
        'title',
        'start_time',
    ];

    // (Optional) Use Carbon casting for start_time
    protected $casts = [
        'start_time' => 'datetime',
    ];
}
