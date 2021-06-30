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

                    @foreach ($users as $user)
                        @php
                            $classColor = '';
                            if (!empty($selectedUserIdsForRandom) && !in_array($user->id, $selectedUserIdsForRandom)) {
                                $classColor = 'linethrough red';
                            }
                        @endphp
                        <a href="{{ route('admin.editUserBalance', ['id' => $user->id]) }}" class="name {{ $classColor }}">
                            {{ $user->name }}
                        </a> 
                        (số dư hiện tại: {{ number_format($user->balance) }} VND) 
                        <br>
                    @endforeach
                </div>

                @if (session('random_user_id'))
                <div class="card-body">
                    <div>
                        <span style="font-size: 1.5rem;">Lần quay thứ {{ session('random_deliver_counter', 1) }} ( ngày {{ date('d-m-Y') }})</span> <br>
                        <span style="color: #ff6b00;">Cảm ơn người được chọn :</span>
                    </div>
                    <div style="font-size: 2rem;" class="alert alert-success" role="alert">
                        {{ session('random_user_id') }}
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
