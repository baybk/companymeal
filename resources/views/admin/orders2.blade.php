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
                        <div class="onepeo">
                            Lí do yêu cầu: <input type="text" name="reason" value="Phí cơm hằng ngày" />
                        </div>
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

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
