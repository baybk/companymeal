@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="subtract">Danh sách Sprint </span> 
                </div>

                <div class="card-body" style="overflow-x: auto;">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="mytable">
                        <thead>
                            <th class="myth">Tên sprint</th>
                            <th class="myth">Sprint mặc định</th>
                            <th class="myth">Hành động</th>
                        </thead>

                        <tbody>
                        @foreach ($sprints as $sprint)
                            <tr>
                                <td class="mytd">{{ $sprint->name }}</td>
                                @if($currentSprint == $sprint->id)
                                <td class="mytd">YES</td>
                                @else
                                <td class="mytd">NO</td>
                                @endif
                                <td class="mytd">
                                    <a href="{{ route('admin.setDefaultSprint', ['sprintId'=>$sprint->id]) }}">Set default sprint</a> |
                                    <a href="{{ route('admin.editSprint', ['sprintId'=>$sprint->id]) }}">Edit</a>
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
        </div>
    </div>
</div>
@endsection