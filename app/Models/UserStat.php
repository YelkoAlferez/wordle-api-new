<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStat extends Model
{
    use HasFactory;

    protected $table = "users_stats";

    protected $fillable = [
        "completion_time",
        "used_attempts",
        "word",
        "completed",
        "user_id"
    ];

    
}
