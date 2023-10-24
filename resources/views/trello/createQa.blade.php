@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Thêm Qa</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.postCreateQa') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="question" class="col-md-2 col-form-label text-md-right">Câu hỏi:</label>

                            <div class="col-md-8">
                                <input id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') }}" required autocomplete="question" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="answer" class="col-md-2 col-form-label text-md-right">Câu trả lời:</label>

                            <div class="col-md-8">
                                <input id="answer" type="text" class="form-control @error('answer') is-invalid @enderror" name="answer" value="{{ old('answer') }}" autocomplete="answer" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('messages.add') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
