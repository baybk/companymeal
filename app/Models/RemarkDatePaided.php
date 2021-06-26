<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemarkDatePaided extends Model
{
    use HasFactory;

    public $fillable = [
        'date_remark',
        'order_number',
        'user_list_paid',
        'reason'
    ];
    public $table = 'remark_date_paided';
}
