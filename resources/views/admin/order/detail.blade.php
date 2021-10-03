@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chi tiết đơn hàng #{{ $order['id'] }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <h4>(1) THÔNG TIN CHUNG (Sửa đổi nếu cần, sau khi xác nhận với khách)</h4>
                    <form method="POST" action="{{ route('admin.orders.update', ['id' => $order['id']]) }}">
                        @csrf
                        <span class="name">Tên khách hàng:</span> <input class="right-box" name="customer_name" type="text" value="{{$order['customer_name']}}" /> <br>
                        <span class="name">Địa chỉ giao:</span> <input class="right-box" name="customer_address" type="text" value="{{$order['customer_address']}}" /> <br>
                        <span class="name">Số điện thoại:</span> <input class="right-box" name="customer_phone" type="text" value="{{$order['customer_phone']}}" disabled /> <br>
                        <span class="name">Tổng tiền đơn hàng:</span> <input class="right-box" name="total_price" type="number" value="{{$order['total_price']}}" /> <br>

                        <span class="name" style="margin-top: 17px;margin-right: -34px !important;">Trạng thái đơn:</span>
                        <select class="btn-delete" name="delivery_status">
                            <option value="">{{ currentAdminOrderDeliveryStatus( $order['delivery_status'] ) }}</option>
                            @foreach ( getProperNextDeliveryOrderStatuses($order['delivery_status']) as $nextStatus )
                            <option value="{{ $nextStatus }}">{{ currentAdminOrderDeliveryStatus($nextStatus) }}</option>
                            @endforeach
                        </select>
                        <br>========<br>
                        <span class="name">Ghi chú của QTV:</span>
                            <textarea name="general_note" class="right-box">
{{ $order['general_note'] }}
                            </textarea>
                        <br>
                        <!-- <span class="name">Mật khẩu QTV:</span><input class="right-box" name="pass" type="password" required/> -->
                        <br>
                        <input type="submit" value="Xác nhận" class="submit-order-1" style="margin-top: 10px;">
                    </form>

                    <h4>(2) CÁC SẢN PHẨM ĐÃ ĐẶT</h4>
                    <table class="mytable">
                        <thead>
                            <th class="myth">Tên sản phầm</th>
                            <th class="myth">Số lượng mua</th>
                            <th class="myth">Đơn giá</th>
                            <th class="myth">Thành tiền</th>
                            <th class="myth">Link sản phẩm</th>
                        </thead>

                        <tbody>
                            @foreach($order['lines'] as $product)
                            <tr>
                                <td class="mytd">{{ $product['productName'] }}</td>
                                <td class="mytd">{{ $product['quantity'] }}</td>
                                <td class="mytd">{{ number_format(intval($product['price'])) }}</td>
                                <td class="mytd">{{ number_format(intval($product['price']) * intval($product['quantity'])) }}</td>
                                <td class="mytd"><a href="{{ FE_URL . '/product.html?pid=' . $product['productId'] }}" target="_blank">Link đây<a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="paginate">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
