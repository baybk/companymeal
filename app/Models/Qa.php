<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qa extends Model
{
    use HasFactory;
    public $table = 'qa';
    public $fillable = [
        'team_id',
        'question',
        'answer',
        'status'
    ];
}
