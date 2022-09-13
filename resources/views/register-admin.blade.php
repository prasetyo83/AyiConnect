@extends('layouts.admin')
@section('title')
New Admin
@endsection
@section('content')
<div class="add-author">
    <div class="author-input">
        <div class="form-block w-form">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Set up Google Authenticator</div>

                    <div class="panel-body" style="text-align: center;">
                        <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code {{ $secret }}</p>
                        <div>
                            {!! $QR_Image !!}
                        </div>
                        <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                        <div>
                            <a href="{{url('/')}}/complete-registration"><button class="btn-primary">Complete Registration</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection
@section('script')
<script>
    // @parent
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    // $('body').on('submit', '#password_form', function(e) {
    //     e.preventDefault();
    //     var formData = new FormData(this);
    //     var actionType = $('#btn-save').val();
    //     $('#savedata').html('Sending..');
    //     $.ajax({
    //         data: formData,
    //         url: "{{ route('setting.store') }}",
    //         type: "POST",
    //         contentType: false,
    //         processData: false,
    //         dataType: 'json',
    //         success: function(data) {
    //             $('#password_form').trigger("reset");
    //             $('.w-form-done').show().delay(5000).fadeOut();
    //             $('#old_status').html('');



    //         },
    //         error: function(data) {
    //             console.log('Error:', data);
    //             $('.w-form-fail').show().delay(5000).fadeOut();
    //         }
    //     });
    // });
    // $('#password_form').validate({
    //     rules: {
    //         old_password: "required",
    //         new_password: {
    //             minlength: 6
    //         },
    //         confirm_password: {
    //             minlength: 6,
    //             equalTo: "#new_password"
    //         }
    //     }
    // });
    // $('#old_password').on('input', function() {
    //     var old_password = $(this).val();
    //     var name= $("#name").val();
    //     if (old_password.length > 4) {
    //         // alert(old_password);
    //         $.ajax({
    //             type: 'POST',
    //             url: '{{ route('setting.store') }}',
    //             data: { old_password: old_password, name: name },
    //             beforeSend: function() {
    //                 $('#old_status').html('checking..');
    //             },
    //             success: function(result) {
    //                 // alert(result);
    //                 if (result.state='fail')
    //                 {
    //                     $('#old_status').html(result.data);
    //                 }
    //                 else
    //                 {
    //                     $('#old_status').html(result.data);
    //                 }

    //             }
    //         });
    //     }
    // });
</script>
@endsection