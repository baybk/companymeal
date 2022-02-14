@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Thành viên : {{ $user->name }}</div>

                <div class="card-body">
                    <h4>(1) Thông tin user</h4>
                    <div>Tên: {{ $user->name }}</div>
                    <div>Số dư hiện tại: {{ number_format($user->balance) }} VND</div>

                    <h4>(2) Xoá user <button class="btn-delete" onclick="return submit()">Xác nhận</button> </h4>

                    <h4>(3) Thay đổi hours per week</h4>
                    <form method="POST" action="{{ route('admin.editUserBalance', ['id' => $user->id]) }}">
                        @csrf
                        Hours per week *: <input name="hours_per_week" type="number" /> <br>
                        Email: <input name="email" type="email" /> <br>
                        <br>
                        <input type="submit" value="Xác nhận">
                    </form>

                    <h4>(4) Các task thuộc sprint hiện tại</h4>
                    <table class="mytable">
                        <thead>
                            <th class="myth">Tên task</th>
                            <th class="myth">Số hours</th>
                            <th class="myth">Ngày bắt đầu</th>
                            <th class="myth">Ngày kết thúc</th>
                            <th class="myth">Hành động</th>
                        </thead>

                        <tbody>
                            @foreach ($currentTasks as $task)
                            <tr>
                                <td class="mytd">{{ $task->name }}</td>
                                <td class="mytd">{{ $task->hours }}</td>
                                <td class="mytd">{{ date('d-m-Y', strtotime($task->from_date)) }}</td>
                                <td class="mytd">{{ date('d-m-Y', strtotime($task->end_date)) }}</td>
                                <td class="mytd">
                                    <a href="{{ route('admin.editTask', ['taskId' => $task->id]) }}">Chỉnh sửa</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="paginate">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function submit() {
        $confirmIsYes = true;
        $confirmIsYes = confirm('Các thông tin liên quan đến người này sẽ xoá khỏi hệ thống. Bạn chắc chắn muốn xoá người dùng? ');
        if ($confirmIsYes == true) {
            //document.getElementById('bt_submit').click();
            window.location.href = "{{ route( 'admin.deleteUser', [ 'id' => $user->id ] ) }}";
        } else {
            return false;
        }
    }
</script>
@endsection
