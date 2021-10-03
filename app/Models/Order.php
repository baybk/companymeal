<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $table = 'orders';

    // protected $guarded = [];
    protected $fillable = [
        'team_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_email',
        'payment_status',
        'delivery_status',
        'general_note',
        'lines',
        'total_price'
    ];

    protected $casts = [
        'lines' => 'array',
        'admin_change_history' => 'array'
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
