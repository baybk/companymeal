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

                    <h4>(1) Thông tin chung (Sửa đổi nếu cần, sau khi xác nhận với khách)</h4>
                    <form method="POST" action="">
                        @csrf
                        <span class="name">Tên khách hàng:</span> <input class="right-box" name="customer_name" type="text" value="{{$order['customer_name']}}" /> <br>
                        <span class="name">Địa chỉ giao:</span> <input class="right-box" name="customer_address" type="text" value="{{$order['customer_address']}}" /> <br>
                        <span class="name">Số điện thoại:</span> <input class="right-box" name="customer_phone" type="text" value="{{$order['customer_phone']}}" disabled /> <br>
                        <span class="name">Tổng tiền đơn hàng:</span> <input class="right-box" name="total" type="text" value="" /> <br>
                        <br>========<br>
                        <span class="name">Ghi chú của QTV:</span>
                            <textarea class="right-box">

                            </textarea>
                        <br>
                        <span class="name">Mật khẩu QTV:</span><input class="right-box" name="pass" type="password" />
                        <br>
                        <input type="submit" value="Xác nhận">
                    </form>

                    <h4>(2) CHUYỂN TRẠNG THÁI ĐƠN THÀNH: 
                        <select class="btn-delete" onclick="">
                            <option>ĐÃ XÁC NHẬN</option>
                            <option>HUỶ</option>
                        </select>
                    </h4>

                    <h4>(3) CÁC SẢN PHẨM ĐÃ ĐẶT</h4>
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
                                <td class="mytd"><a href="{{ FE_URL . '/product.html?pid=' . $product['productId'] }}">Link<a></td>
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

@section('js')
<script>
    function submit() {
        $confirmIsYes = true;
        $confirmIsYes = confirm('Các thông tin liên quan đến người này sẽ xoá khỏi hệ thống. Bạn chắc chắn muốn xoá người dùng? ');
        if ($confirmIsYes == true) {
            window.location.href = "";
        } else {
            return false;
        }
    }
</script>
@endsection
