
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if (session('my_error'))
            <div class="message-error">
                <strong>{{ session('my_error') }}</strong>
            </div>
            @endif


            <div class="card">
                <div class="card-header">Sign pdf</div>

                <div class="card-body">
                    <form id="signForm">
                        @csrf

                        <div class="form-group row">
                            <label for="pdf_url" class="col-md-4 col-form-label text-md-right">Pdf url file:</label>

                            <div class="col-md-6">
                                <input id="pdf_url" type="text" class="form-control @error('pdf_url') is-invalid @enderror" name="pdf_url" value="{{ old('pdf_url') }}" required autocomplete="pdf_url" autofocus>

                                @error('pdf_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sign_pos" class="col-md-4 col-form-label text-md-right">Sign pos:</label>

                            <div class="col-md-6">
                                <input id="sign_pos" type="text" class="form-control @error('sign_pos') is-invalid @enderror" name="sign_pos" value="{{ old('sign_pos') }}" required autocomplete="sign_pos" autofocus>

                                @error('sign_pos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" id="submit" class="btn btn-primary">
                                    Xác nhận
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
      
<script>
    $('#submit').on('click',function(e){
        e.preventDefault();

        let pdf_url = $('#pdf_url').val();
        let sign_pos = $('#sign_pos').val();

        $.ajax({
            type:'POST',
            url:'http://localhost:32318/ca/sign-pdf/',
            data:{
                "_token": "{{ csrf_token() }}",
                pdf_url: pdf_url,
                sign_pos: sign_pos,
                reason: 'sign contract'
            },
            success:function(response){
                console.log(response);
                if (response) {
                    $('#success-message').text(response.success);
                    alert('ok') 
                    // $("#cForm")[0].reset(); 
                }
            },
            error: function(response) {
                // $('#name-error').text(response.responseJSON.errors.name);
                // $('#email-error').text(response.responseJSON.errors.email);
                // $('#mobile-number-error').text(response.responseJSON.errors.mobile_number);
                // $('#subject-error').text(response.responseJSON.errors.subject);
                // $('#message-error').text(response.responseJSON.errors.message);
                alert('errrorr');
            }
        });
    });
</script>

