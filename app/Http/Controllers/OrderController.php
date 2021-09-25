<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    public function store(Request $request)
    {
        $inputData = $request->all();
        Log::info($inputData);
        $inputData['payment_status'] = PAYMENT_STATUS_WAITING;
        $inputData['delivery_status'] = DELIVERY_STATUS_REQUEST;
        Order::create($inputData);
        return $this->makeSuccessWithoutMessage([]);
    }
}
