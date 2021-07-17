<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersTeam extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'team_id',
        'role'
    ];
}
