@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn" href="#">Danh sách Notes</a> |
                    <a class="btn mybtn" href="{{ route('admin.createNote') }}">Tạo Note</a>
                </div>

                <div class="card-body" style="overflow-x: auto;">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="mytable">
                        <thead>
                            <th class="myth">Tiêu đề</th>
                            <th class="myth">Nội dung</th>
                            <th class="myth">Hành động</th>
                        </thead>

                        <tbody>
                        @foreach ($notes as $note)
                            <tr>
                                <td class="mytd">{{ $note->title }}</td>
                                <td class="mytd">
                                    <?php
                                        if ($note->type == 'LINK') {
                                    ?>
                                        <a target="_blank" href="{{ $note->value }}">{{ $note->value }}</a>
                                    
                                    <?php
                                        } else if ($note->type == 'TEXT') {
                                    ?>
                                        <textarea>{{ $note->value }}</textarea>

                                    <?php } else { ?>
                                        {{ $note->value }}
                                    <?php } ?>
                                </td>
                                <td class="mytd">
                                    <a href="{{ route('admin.deleteNote', ['noteId' => $note->id]) }}">Xoá</a>
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