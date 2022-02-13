@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="subtract">Sprint đang xem:  {{ $currentSprint ? $currentSprint->name : 'Chưa có sprint' }}</span> 
                </div>

                <div class="card-body" style="overflow-x: auto;">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="mytable">
                        <thead>
                            <th class="myth">Họ tên</th>
                            <th class="myth">Email</th>
                            <th class="myth">Hours per week Setting</th>
                            <th class="myth">Workload hiện tại</th>
                            <th class="myth">Ghi chú</th>
                            <th class="myth">Hành động</th>
                        </thead>

                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="mytd">{{ $user->name }}</td>
                                <td class="mytd">{{ $user->email }}</td>
                                <td class="mytd">{{ $user->hours_per_week }}</td>
                                <td class="mytd">{{ $user->sum_hours }}</td>
                                <td class="mytd">{{ $user->status_hours }}</td>
                                <td class="mytd">
                                    <a href="{{ route('admin.editUserBalance', ['id'=> $user->id]) }}">Chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="paginate">
                        <!-- $users->links() -->
                    </div>
                </div>
            </div>



            <div class="card">
                <div class="card-header">
                    <span class="subtract">Chi tiết Sprint đang xem:  {{ $currentSprint ? $currentSprint->name : 'Chưa có sprint' }}</span> 
                </div>

                <div class="card-body" style="overflow-x: auto;">
                    <textarea rows="20" cols="100" name="detail" >{{ $currentSprint ? $currentSprint->detail : '' }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection