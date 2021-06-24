@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('CẬP NHẬT NGƯỜI DÙNG') }} : {{ $user->name }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h4>(1) Thay đổi số dư (cưỡng ép)</h4>
                    <form method="POST" action="{{ route('admin.editUserBalance', ['id' => $user->id]) }}">
                        @csrf
                        Cộng/trừ 1 lượng (VNĐ): <input name="money" type="text" /> <br>
                        Lí do Cộng/trừ:_________<input name="reason" type="text" /> <br>
                        Password:_____________<input name="pass" type="password" />
                        <br>
                        <input type="submit" value="Xác nhận">
                    </form>

                    <h4>(2) Thông tin user</h4>
                    <div>Tên: {{ $user->name }}</div>
                    <div>Số dư hiện tại: {{ number_format($user->balance) }} VND</div>

                    <h4>(3) Lịch sử thay đổi số dư</h4>
                    <table class="mytable">
                        <thead>
                            <th class="myth">Day</th>
                            <th class="myth">Reason</th>
                            <th class="myth">Old balance</th>
                            <th class="myth">Change number</th>
                        </thead>

                        <tbody>
                            @foreach ($userHistories as $history)
                            <tr>
                                <td class="mytd">{{ $history->created_at }}</td>
                                <td class="mytd">{{ $history->reason }}</td>
                                <td class="mytd">{{ $history->balance_before_change }} VND</td>
                                <td class="mytd">{{ $history->change_number }} VND</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="paginate">
                        {{ $userHistories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
