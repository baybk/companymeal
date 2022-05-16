@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tạo task
                    @if($currentSprint != null && $latestSprint != null && $latestSprint->id != $currentSprint->id)
                    <i style="color:red">(Chú ý: Bạn đang xem sprint không phải mới nhất)</i>
                    @endif
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.postCreateTask') }}">
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
                                    <option value="Fullstack">Fullstack</option>
                                    <option value="Backend">Backend</option>
                                    <option value="Frontend">Frontend</option>
                                    <option value="Design">Design</option>
                                    <option value="BA">BA</option>
                                    <option value="Database">Database</option>
                                    <option value="Testing">Testing</option>
                                    <option value="General">General</option>
                                    <option value="Deployment">Deployment</option>
                                </select>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                                <select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hours" class="col-md-4 col-form-label text-md-right">Số giờ</label>

                            <div class="col-md-6">
                                <input id="hours" type="text" class="form-control @error('hours') is-invalid @enderror" name="hours" value="{{ old('hours') }}" required autocomplete="hours" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="from_date" class="col-md-4 col-form-label text-md-right">Ngày Bắt đầu</label>

                            <div class="col-md-6">
                                <input style="display:inline;width:70%" id="from_date" type="date" class="form-control @error('from_date') is-invalid @enderror" name="from_date" value="{{ old('from_date') }}" required autocomplete="from_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">Ngày Kết thúc</label>

                            <div class="col-md-6">
                                <input style="display:inline;width:70%" id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required autocomplete="end_date" autofocus>
                                <input placeholder="Đến giờ" style="display:inline;width:20%" max="24" name="end_time" type="number" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">Ghi chú:</label>
                            <div class="col-md-8">
                                <textarea rows="10" cols="100" name="desc" >{{ old('desc') }}</textarea>
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
