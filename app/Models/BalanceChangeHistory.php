<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceChangeHistory extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'team_id',
        'reason',
        'balance_before_change',
        'change_number',
    ];
    public $table = 'balance_change_histories';
}
