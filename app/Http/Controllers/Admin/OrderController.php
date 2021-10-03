<?php

namespace App\Http\Controllers\Admin;

use App\Http\Contract\UserBusiness;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller {
    use UserBusiness;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('adminAuth');
    }

    public function index() {
        $orders = Order::where('team_id', $this->getCurrentTeam()->id)
                                            ->orderBy('id', 'desc')
                                            ->simplePaginate(10);
        return view('admin.orders', compact('orders'));
    }

    public function show(Request $request, $id)
    {
        $order = Order::findOrFail($id)->toArray();
        return view('admin.order.detail', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $inputData = $request->all();
        if (!isset($inputData['delivery_status']) || (isset($inputData['delivery_status'])  && empty($inputData['delivery_status']) ) ) {
            unset($inputData['delivery_status']);
        }
        $order->update($inputData);
        $request->session()->flash('message', "Cập nhật thành công!");
        return redirect()->route('admin.orders.show', ['id' => $id]);
    }
}