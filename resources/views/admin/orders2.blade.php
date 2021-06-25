@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><span class="subtract">Request trừ tiền cơm ( cho ngày {{ date('d-m-Y') }} )</span> <br>(Hiện tại mặc định 1 bữa ăn có giá {{ env('MEAL_PRICE', 20000) }} VND)</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h5 class="h5-guide">Đánh dấu những người đặt cơm. Sau đó nhấn xác nhận để trừ số dư của họ</h5>

                    <form method="POST" action="{{ route('admin.postOrders2') }}">
                        @csrf
                        @foreach ($users as $user)
                        <div class="onepeo">
                            <input class="onecb" name="userIds[]" type="checkbox" value="{{ $user->id }}" /> 
                            <a href="{{ route('admin.editUserBalance', ['id' => $user->id]) }}" class="name">{{ $user->name }}</a> 
                            <input class="onemoney" name="list_money[{{ $user->id }}]" type="number" value="{{ env('MEAL_PRICE', 20000) }}" /> 
                            <br>
                        </div>
                        @endforeach

                        <br>
                        <input type="submit" value="Xác nhận">
                    </form>

                    <h4>Ngày request gần nhất</h4>
                    <table class="mytable">
                        <thead>
                            <th class="myth">Day</th>
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
