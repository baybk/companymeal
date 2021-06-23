@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><span class="subtract">Request trừ tiền cơm ( cho ngày {{ date('d-m-Y') }} )</span> <br>(Hiện tại mặc định 1 bữa ăn có giá 20k)</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.postOrders') }}">
                        @csrf
                        @foreach ($users as $user)
                        <input name="userIds[]" type="checkbox" value="{{ $user->id }}" /> : <span class="name">{{ $user->name }}</span> (số dư hiện tại: {{ number_format($user->balance) }} VND) <br>
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
                                <td class="mytd">{{ $lastPaided->order_number }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
