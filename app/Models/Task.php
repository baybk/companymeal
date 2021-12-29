<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'team_id',
        'sprint_id',
        'from_date',
        'end_date',
        'hours',
        'story_point',
        'user_id',
        'detail'
    ];
}
