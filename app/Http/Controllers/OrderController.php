<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\SendOrderDataToBotNotification;
use Exception;
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
        try {
            $order = Order::create($inputData);
            $inputData['manager_link'] = getAppUrl() . '/admin/orders/' . $order->id; 
            User::first()->notify(new SendOrderDataToBotNotification("ĐƠN HÀNG MỚI", $inputData));
            return $this->makeSuccessWithoutMessage([]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->makeError([], $e->getMessage(), 400);
        } 
    }
}
