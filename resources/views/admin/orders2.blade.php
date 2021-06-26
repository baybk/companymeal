@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><span class="subtract">Request trừ tiền ( cho ngày {{ date('d-m-Y') }} )</span></div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h5 class="h5-guide">Đánh dấu những người đã đặt. Sau đó nhấn xác nhận để trừ số dư của họ</h5>

                    <form method="POST" action="{{ route('admin.postOrders2') }}">
                        @csrf
                        <input type="hidden" id="id_type_submit" name="type_submit" value="1" />
                        <div class="onepeo">
                            Lí do yêu cầu: 
                            <select id="id_reason_selection" name="reason_type" onchange="return onChangeReason()">
                                <option value="DAILY_RICE">Phí cơm hằng ngày</option>
                                <option value="OTHER">Lí do khác</option>
                            </select>
                            
                            <input id="id_reason_input" style="display:none" type="text" name="reason" value="Ăn vặt .." /> <br>
                        </div>
                        @foreach ($users as $user)
                        <div class="onepeo">
                            <input class="onecb" name="userIds[]" type="checkbox" value="{{ $user->id }}" /> 
                            <a href="{{ route('admin.editUserBalance', ['id' => $user->id]) }}" class="name">{{ $user->name }}</a> 
                            <input class="onemoney" name="list_money[{{ $user->id }}]" type="number" value="{{ env('MEAL_PRICE', 20000) }}" /> <span>VND</span>
                            <br>
                        </div>
                        @endforeach

                        <br>
                        <input onclick="return submitOrder(1)" class="submit-order-1" type="button" value="Trừ tiền và random người mua">
                        <input onclick="return submitOrder(2)" class="submit-order-2" type="button" value="Chỉ trừ tiền"> 
                        <input onclick="return submitOrder(3)" class="submit-order-3" type="button" value="Chỉ random người mua">
                        <input style="display:none" id="bt_submit_order" type="submit">
                    </form>

                    <h4>Ngày request gần nhất</h4>
                    <table class="mytable">
                        <thead>
                            <th class="myth">Ngày đã đặt cơm</th>
                            <th class="myth">Số người được request</th>
                        </thead>

                        <tbody>
                        @foreach ($lastPaidedList as $lastPaided)
                            <tr>
                                <td class="mytd">{{ $lastPaided->date_remark }}</td>
                                <td class="mytd">{{ $lastPaided->user_list_paid }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="paginate">
                        {{ $lastPaidedList->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function onChangeReason() {
        var valueSelected = document.getElementById('id_reason_selection').value;
        var displayStatus = 'none';
        if (valueSelected == 'OTHER') {
            displayStatus = '';
        }
        document.getElementById('id_reason_input').style.display = displayStatus;
    }

    function submitOrder(type) {
        document.getElementById('id_type_submit').value = type;

        $confirmIsYes = true;
        if (type == 1) {
            $confirmIsYes = confirm('Bạn chắc chắn muốn request trừ tiền + random người mua?');
        }
        if (type == 2) {
            $confirmIsYes = confirm('Bạn chắc chắn muốn request trừ tiền?');
        }
        if ($confirmIsYes == true) {
            document.getElementById('bt_submit_order').click();
        } else {
            return false;
        }
    }
</script>
@stop
