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
                    @if (session('flash_message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('flash_message') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.postCreateTask') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Tên task</label>

                            <div class="col-md-6">
                                <input id="stt" type="number" class="col-md-3" name="stt" value="{{ old('stt') }}" autocomplete="stt" />
                                <select name="story">
                                    <option value="">--------</option>
                                    @foreach($stories as $story)
                                    <option value="{{ $story->name }}">{{ $story->desc }}</option>
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
                                    <option value="EstimateStory">EstimateStory</option>
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
                                <input id="hours" style="display:inline;width:60%" type="text" class="form-control @error('hours') is-invalid @enderror" name="hours" value="{{ old('hours', 3) }}" required autocomplete="hours" autofocus>
                                <button type="button" class="btn btn-primary" style="display:inline;width:20%" data-toggle="modal" data-target="#myModal">Chi tiết</button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="from_date" class="col-md-4 col-form-label text-md-right">Ngày Bắt đầu</label>

                            <div class="col-md-6">
                                <input style="display:inline;width:70%" id="from_date" type="date" class="form-control @error('from_date') is-invalid @enderror" name="from_date" value = "<?php echo date('Y-m-d'); ?>"  required autocomplete="from_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">Ngày Kết thúc</label>

                            <div class="col-md-6">
                                <input style="display:inline;width:70%" id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value = "<?php echo date('Y-m-d'); ?>" required autocomplete="end_date" autofocus>
                                <input placeholder="Đến giờ" style="display:inline;width:20%" max="24" name="end_time" type="number" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">Ghi chú:</label>
                            <div class="col-md-8">
                                <textarea rows="5" cols="100" name="desc" >{{ old('desc') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('messages.add') }}
                                </button>
                            </div>
                        </div>


                        <!-- MODAL DETAIL HOURS -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tính chi tiết giờ theo công thức</h5>
                                    <button class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    
                                    <div class="col-md-12">
                                        BE Hours: <input onkeyup="calcTotalHours()" id="hours_for_backend" style="display:inline;width:30%" type="text" class="form-control @error('hours_for_backend') is-invalid @enderror" name="hours_for_backend" value="{{ old('hours_for_backend', 0) }}" autocomplete="hours" autofocus>
                                        FE Hours: <input onkeyup="calcTotalHours()" id="hours_for_frontend" style="display:inline;width:30%" type="text" class="form-control @error('hours_for_frontend') is-invalid @enderror" name="hours_for_frontend" value="{{ old('hours_for_frontend', 0) }}" autocomplete="hours_for_frontend" autofocus>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script type="text/javascript">
    function calcTotalHours() {
        const hours_for_backend = $("#hours_for_backend").val();
        const hours_for_frontend = $("#hours_for_frontend").val();
        if (!hours_for_backend || !hours_for_frontend) {
            return false;
        }

        const hours_for_backend_int = parseInt(hours_for_backend)
        const hours_for_frontend_int = parseInt(hours_for_frontend)

        let requirement_cost = (hours_for_backend_int+hours_for_frontend_int)*20/100
        let design_cost = (hours_for_backend_int+hours_for_frontend_int)*25/100
        let testing_cost = (hours_for_backend_int+hours_for_frontend_int)*20/100
        let fixing_cost = (hours_for_backend_int+hours_for_frontend_int)*10/100
        let deployment_cost = (hours_for_backend_int+hours_for_frontend_int)*4/100

        requirement_cost = Math.round(requirement_cost * 10) / 10;
        design_cost = Math.round(design_cost * 10) / 10;
        testing_cost = Math.round(testing_cost * 10) / 10;
        fixing_cost = Math.round(fixing_cost * 10) / 10;
        deployment_cost = Math.round(deployment_cost * 10) / 10;

        let total = hours_for_backend_int + hours_for_frontend_int + requirement_cost + design_cost + testing_cost + fixing_cost + deployment_cost
        total = Math.round(total);
        
        $("#hours").val(total)
        $("#requirement_cost").val(requirement_cost)
        $("#design_cost").val(design_cost)
        $("#testing_cost").val(testing_cost)
        $("#fixing_cost").val(fixing_cost)
        $("#deployment_cost").val(deployment_cost)
    }
</script>
@endsection