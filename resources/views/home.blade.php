@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Danh sách thành viên 
                    @if (Auth::user()->role == 'admin') 
                        <span class="balance-total">$ Tổng số dư ước tính: {{ number_format($totalBalance) }} VND</span>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Auth::user()->role == 'admin')
                        @foreach ($users as $user)
                        <a href="{{ route('admin.editUserBalance', ['id' => $user->id]) }}" class="name">{{ $user->name }}</a> (số dư hiện tại: {{ number_format($user->balance) }} VND) 
                            @if (Auth::user()->role == 'admin') 
                                => <a href="{{ route('admin.editUserBalance', ['id' => $user->id]) }}">Chi tiết</a>
                            @endif
                            <br>
                        @endforeach
                    @else
                        @foreach ($users as $user)
                            <span class="name">{{ $user->name }}</span> (số dư hiện tại: {{ number_format($user->balance) }} VND) 
                            <br>
                        @endforeach
                    @endif
                </div>

                @if (session('selectedUserId'))
                <div class="card-body">
                    <h5 style="color: #ff6b00;">Cảm ơn người được chọn hôm nay ({{ date('d-m-Y') }}):</h5>
                        <div style="font-size: 2rem;" class="alert alert-success" role="alert">
                            {{ session('selectedUserId') }}
                        </div>
                </div>
                @endif

                <div class="card-body">
                    <h5>Công cụ hỗ trợ:</h5>
                    <a href="{{ route('admin.randomDeliver') }}">Quay random ID</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
