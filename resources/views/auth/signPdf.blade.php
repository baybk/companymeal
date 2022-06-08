
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if (session('my_error'))
            <div class="message-error">
                <strong>{{ session('my_error') }}</strong>
            </div>
            @endif


            <div class="card">
                <h2 class="card-header">Sign pdf</h2>

                <div class="card-body">
                    <form id="signForm">
                        @csrf

                        <div class="form-group row">
                            <label for="pdf_url" class="col-md-4 col-form-label text-md-right">Pdf url file:</label>

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
                            <label for="sign_pos" class="col-md-4 col-form-label text-md-right">Sign pos:</label>

                            <div class="col-md-6">
                                <input style="padding: 4px;" id="sign_pos" type="text" class="form-control @error('sign_pos') is-invalid @enderror" name="sign_pos" value="{{ old('sign_pos', '50x50') }}" required autocomplete="sign_pos" autofocus>

                                @error('sign_pos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cts" class="col-md-4 col-form-label text-md-right">Serial CTS:</label>

                            <div class="col-md-6">
                                <input style="padding: 4px;" id="cts" type="text" class="form-control @error('cts') is-invalid @enderror" name="cts" value="{{ old('cts') }}" required autocomplete="cts" autofocus>

                                @error('cts')
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
    function base64ToArrayBuffer(base64) {
        var binaryString = window.atob(base64);
        var binaryLen = binaryString.length;
        var bytes = new Uint8Array(binaryLen);
        for (var i = 0; i < binaryLen; i++) {
        var ascii = binaryString.charCodeAt(i);
        bytes[i] = ascii;
        }
        return bytes;
    }

    function saveByteArray(reportName, byte) {
        var blob = new Blob([byte], {type: "application/pdf"});
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        var fileName = reportName;
        link.download = fileName;
        link.click();
    };

    $('#submit').on('click',function(e){
        e.preventDefault();

        let pdf_url = $('#pdf_url').val();
        let sign_pos = $('#sign_pos').val();
        let cts = $('#cts').val();

        $.ajax({
            type:'POST',
            url:'http://localhost:32318/api/ca/sign-pdf/' + cts,
            data:{
                "_token": "{{ csrf_token() }}",
                pdf_url: pdf_url,
                sign_pos: sign_pos,
                reason: 'sign contract'
            },
            success:function(response){
                console.log(response)
                if (response) {                    
                    const myFileXml = new File([response], "file.pdf", {
                                                    type: 'application/pdf',
                                                });
                    // const myFileXml = new Blob([response], {type: "application/pdf"});
                    const url = window.URL.createObjectURL(myFileXml);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = 'file.pdf';
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

