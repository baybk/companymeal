@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn {{ $isTodayTask ? '' : 'red' }}" href="{{ route('admin.todayTask') }}">All tasks</a> |
                    <a class="btn {{ $isTodayTask ? 'red' : '' }}" href="{{ route('admin.todayTask') }}?is_today_task=true">Today's tasks</a>
                </div>

                <div class="card-body">
                    @foreach($data as $dataOneUser)
                        <h4>Thành viên: {{ $dataOneUser['user']['name'] }}</h4>
                        <table class="mytable">
                            <thead>
                                <th class="myth">Tên task</th>
                                <th class="myth">Số hours</th>
                                <th class="myth">Ngày bắt đầu</th>
                                <th class="myth">Ngày kết thúc</th>
                                <th class="myth">Tiến độ %</th>
                                <th class="myth">Hành động</th>
                            </thead>

                            <tbody>
                                @foreach ($dataOneUser['tasks'] as $task)
                                <tr>
                                    <td class="mytd">{{ $task->name }}</td>
                                    <td class="mytd">({{ $task->hours }} giờ) </td>
                                    <td class="mytd">{{ date('d-m-Y', strtotime($task->from_date)) }}  -></td>
                                    <td class="mytd">{{ date('d-m-Y', strtotime($task->end_date)) }}  {{ $task->end_time }}:00h</td>
                                    <td class="mytd">({{ $task->progress }} %) </td>
                                    <td class="mytd">
                                        <a href="{{ route('admin.editTask', ['taskId' => $task->id]) }}">Chỉnh sửa</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
