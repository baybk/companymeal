@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="subtract">Danh sách Story </span> 
                </div>

                <div class="card-body" style="overflow-x: auto;">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="mytable">
                        <thead>
                            <th class="myth">Kí hiệu story</th>
                            <th class="myth">Tên story</th>
                            <th class="myth">Hành động</th>
                        </thead>

                        <tbody>
                        @foreach ($stories as $story)
                            <tr>
                                <td class="mytd">{{ $story->name }}</td>
                                <td class="mytd">{{ $story->desc }}</td>
                                <td class="mytd">
                                    <a href="">Chỉnh sửa</a>
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