@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span class="subtract">Đơn hàng gần nhất</span> 
                </div>

                <div class="card-body" style="overflow-x: auto;">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="mytable">
                        <thead>
                            <th class="myth">Họ tên</th>
                            <th class="myth">Số phone</th>
                            <th class="myth">Địa chỉ</th>
                            <th class="myth">Trạng thái đơn</th>
                            <th class="myth">Số sản phẩm</th>
                            <th class="myth">Hành động</th>
                        </thead>

                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="mytd">{{ $order->customer_name }}</td>
                                <td class="mytd">{{ $order->customer_phone }}</td>
                                <td class="mytd">{{ $order->customer_address }}</td>
                                <td class="mytd">{{ currentAdminOrderDeliveryStatus($order->delivery_status) }}</td>
                                <td class="mytd">
                                    @if (is_array($order->lines))
                                        {{ count($order->lines) }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="mytd">
                                    <a href="{{ route('admin.orders.show', ['id' => $order->id]) }}">Chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="paginate">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
