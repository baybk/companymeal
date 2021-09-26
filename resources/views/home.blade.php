@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Danh sách khách hàng
                    @if (isAdminUserHelper() == 'admin') 
                        {{-- <span class="balance-total">$ Tổng số dư ước tính: {{ number_format($totalBalance) }} VND</span> --}}
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
                        (email: {{ $user->email }}) 
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
            </div>
        </div>
    </div>
</div>
@endsection
