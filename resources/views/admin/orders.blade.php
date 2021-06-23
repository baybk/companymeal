@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Trừ tiền cơm vào số dư cho mọi người') }} (Hiện tại mặc định 1 bữa ăn có giá 20k)</div>

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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
