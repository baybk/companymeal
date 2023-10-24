@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn" href="#">Danh sách Q&A</a> |
                    <a class="btn mybtn" href="{{ route('admin.createQa') }}">Tạo QA</a>
                </div>

                <div class="card-body" style="overflow-x: auto;">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="mytable">
                        <thead>
                            <th class="myth">Câu hỏi</th>
                            <th class="myth">Trả lời</th>
                            <th class="myth">Hành động</th>
                        </thead>

                        <tbody>
                        @foreach ($notes as $note)
                            <tr>
                                <td class="mytd">{{ $note->question }}</td>
                                <td class="mytd">{{ $note->answer }}</td>
                                <td class="mytd">
                                    <a href="{{ route('admin.deleteQa', ['qaId' => $note->id]) }}">Xoá</a>
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