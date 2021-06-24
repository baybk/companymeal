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
                                => <a href="{{ route('admin.editUserBalance', ['id' => $user->id]) }}">Details</a>
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

                @if (Auth::user()->role == 'admin') 
                <div class="card-body">
                    <h4>Chọn người mua cơm hôm nay</h4>
                    <a href="{{ route('admin.randomDeliver') }}">Quay random</a>

                    @if (session('selectedUserId'))
                        <div class="alert alert-success" role="alert">
                            {{ session('selectedUserId') }}
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
