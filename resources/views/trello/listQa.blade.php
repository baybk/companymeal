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
                            <th class="myth">Status</th>
                            <th class="myth">Hành động</th>
                        </thead>

                        <tbody>
                        @foreach ($notes as $note)
                            @php
                                $progressColor = '';
                                if ($note->status == 'DONE') {
                                    $progressColor = 'color: green;';
                                }
                            @endphp
                            <tr>
                                <td class="mytd" style="{{$progressColor}}">
                                    <input type="hidden" id="question_{{$note->id}}" value="{{ $note->question }}">
                                    {{ $note->question }}
                                </td>
                                <td class="mytd">
                                    <input type="hidden" id="answer_{{$note->id}}" value="{{ $note->answer }}">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="showDataInModal({{$note->id}})">Chi tiết</button>
                                </td>
                                <td class="mytd">{{ $note->status }}</td>
                                <td class="mytd">
                                    <a href="{{ route('admin.updateDoneQa', ['qaId' => $note->id]) }}">Done</a> |
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
    
    <!-- MODAL DETAIL HOURS -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật câu trả lời</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    Câu hỏi: <input type="text" id="question" name="question" class="form-control" autofocus>
                </div>

                <div class="col-md-12">
                    Câu trả lời: <textarea id="answer" name="answer" class="form-control" rows="10"  autofocus></textarea>
                </div>
                <input type="hidden" id="current_qa_id" value="">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button class="btn btn-primary" onclick="submitUpdateQA()">Cập nhật</button>
            </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script type="text/javascript">
    function showDataInModal(noteId) {
        $("#answer").val("");
        $("#question").val("");

        const answer = $("#answer_"+ noteId).val();
        const question = $("#question_"+ noteId).val();
        if (answer) {
            $("#answer").val(answer)
        }
        if (question) {
            $("#question").val(question)
        }
        $("#current_qa_id").val(noteId)
    }

    function submitUpdateQA() {
        const answer = $("#answer").val();
        const question = $("#question").val();
        const current_qa_id = $("#current_qa_id").val();

        if (answer || question) {
            alert("submit....id=" + current_qa_id);
            // TODO : send form update to Backend
        } else {
            alert("Vui lòng nhập thông tin!")
        }
    }
</script>
@endsection