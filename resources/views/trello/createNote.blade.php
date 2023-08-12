@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Thêm story</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.postCreateNote') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="title" class="col-md-2 col-form-label text-md-right">Tiêu đề:</label>

                            <div class="col-md-8">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-md-2 col-form-label text-md-right">Loại:</label>

                            <div class="col-md-8">
                                <select name="type" class="form-control">
                                    <option value="LINK">LINK</option>
                                    <option value="TEXT">TEXT</option>
                                    <option value="OTHER">OTHER</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="value" class="col-md-2 col-form-label text-md-right">Nội dung:</label>

                            <div class="col-md-8">
                                <textarea rows="10" id="value" class="form-control @error('value') is-invalid @enderror" name="value" required autocomplete="value" autofocus>{{ old('value') }}</textarea>
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
