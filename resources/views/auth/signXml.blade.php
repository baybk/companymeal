
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if (session('my_error'))
            <div class="message-error">
                <strong>{{ session('my_error') }}</strong>
            </div>
            @endif


            <div class="card">
                <h2 class="card-header">Sign XML</h2>

                <div class="card-body">
                    <form id="signForm">
                        @csrf

                        <div class="form-group row">
                            <label for="pdf_url" class="col-md-4 col-form-label text-md-right">XML url file:</label>

                            <div class="col-md-6">
                                <input style="width: 50%;padding: 4px;" id="pdf_url" type="text" class="form-control @error('pdf_url') is-invalid @enderror" name="pdf_url" value="{{ old('pdf_url') }}" required autocomplete="pdf_url" autofocus>

                                @error('pdf_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sign_pos" class="col-md-4 col-form-label text-md-right">Tag path:</label>

                            <div class="col-md-6">
                                <input style="padding: 4px;" id="sign_pos" type="text" class="form-control @error('sign_pos') is-invalid @enderror" name="sign_pos" value="{{ old('sign_pos', 'HDon/DSCKS/NBan') }}" required autocomplete="sign_pos" autofocus>

                                @error('sign_pos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="uu_id" class="col-md-4 col-form-label text-md-right">UUID:</label>

                            <div class="col-md-6">
                                <input style="padding: 4px;" id="uu_id" type="text" class="form-control @error('uu_id') is-invalid @enderror" name="uu_id" value="{{ old('uu_id') }}" required autocomplete="uu_id" autofocus>

                                @error('uu_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button style="margin-top: 20px; padding: 5px;" type="button" id="submit" class="btn btn-primary">
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
        let uu_id = $('#uu_id').val();

        $.ajax({
            type:'POST',
            url:'http://localhost:32318/api/ca/sign-xml/',
            data:{
                "_token": "{{ csrf_token() }}",
                xml_url: pdf_url,
                tag_path: sign_pos,
                reason: 'sign contract',
                sign_pos: '50x50',
                uu_id: uu_id
            },
            success:function(response){
                if (response) {                    
                    const myFileXml = new File([response.data], "file.xml", {
                                                    type: 'application/xml',
                                                });
                    const url = window.URL.createObjectURL(myFileXml);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    // the filename you want
                    a.download = 'file.xml';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    alert('your file has downloaded!');
                    
                }
            },
            error: function(response) {
                alert('errrorr');
            }
        });
    });
</script>

