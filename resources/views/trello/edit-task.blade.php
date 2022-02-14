@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Câp nhật task</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.postEditTask', ['taskId' => $task->id]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Tên task</label>

                            <div class="col-md-6">
                                <select name="story">
                                    <option value="">--------</option>
                                    @foreach($stories as $story)
                                    <option value="{{ $story->name }}">{{ $story->name }}_{{ $story->desc }}</option>
                                    @endforeach
                                    <option></option>
                                </select>
                                <select name="task_type">
                                    <option value="">--------</option>
                                    <option value="Backend">Backend</option>
                                    <option value="Frontend">Frontend</option>
                                    <option value="Design">Design</option>
                                    <option value="BA">BA</option>
                                    <option value="Database">Database</option>
                                    <option value="Testing">Testing</option>
                                </select>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $task->name) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right">Assign to</label>

                            <div class="col-md-6">
                                <select name="user_id">
                                @php
                                $old_assign = old('user_id', $task->user_id)
                                @endphp
                                @foreach ($users as $user)
                                    @if($old_assign == $user->id)
                                    <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                    @else
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                                <select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hours" class="col-md-4 col-form-label text-md-right">Số giờ</label>

                            <div class="col-md-6">
                                <input id="hours" type="text" class="form-control @error('hours') is-invalid @enderror" name="hours" value="{{ old('hours', $task->hours) }}" required autocomplete="hours" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="from_date" class="col-md-4 col-form-label text-md-right">Ngày Bắt đầu</label>

                            <div class="col-md-6">
                                <input id="from_date" type="date" class="form-control @error('from_date') is-invalid @enderror" name="from_date" value="{{ old('from_date', $task->from_date) }}" required autocomplete="from_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">Ngày Kết thúc</label>

                            <div class="col-md-6">
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', $task->end_date) }}" required autocomplete="end_date" autofocus>
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
