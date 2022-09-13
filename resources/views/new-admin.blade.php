@extends('layouts.admin')
@section('title')
New Admin
@endsection
@section('content')
<div class="add-author">
    <div class="author-input">
        <div class="form-block w-form">

            <form id="newadmin_form" name="wf-form-author-form" class="form" data-name="newadmin-form" method="post" enctype="multipart/form-data" action="{{ route('registeradmin') }}">
                @csrf
                
                <label for="name-image" class="teksti">Username </label><input type="text" class="text-field w-input" name="username" data-name="username" placeholder="Insert Username" id="username" required="" value="">
                @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label class="teksti" id="old_status"></label>
                <label for="name-image" class="teksti">Password </label><input type="password" class="text-field w-input" name="password" data-name="password" placeholder="Insert Password" id="password" required="" value="">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="name-image" class="teksti">Confrim Password </label> <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                <label for="name-image" class="teksti">Name </label><input type="text" class="text-field w-input" name="name" data-name="name" placeholder="Input Name" id="name" required="" value="">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label for="name-image" class="teksti">Email </label><input type="email" class="text-field w-input" name="email" data-name="email" placeholder="Input a Valid Email" id="email" required="" value="">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="name-image" class="teksti">Company Name </label><input type="text" class="text-field w-input" name="company_name" data-name="company_name" placeholder="input company name" id="company_name" required="" value="">
                @error('company_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label id="premium-section" class="w-checkbox premium-checkbox"><input type="checkbox" name="isadmin" id="isadmin" data-name="isadmin" class="w-checkbox-input checkbox-2"><span class="checkbox-text w-form-label" for="checkbox">Is Administrator?</span></label>
                <input type="submit" value="Save" data-wait="Please wait..." id="savedata" class="button-3 w-button">

                <div class="w-form-done">
                    <div>Thank you! Your submission has been received!</div>
                </div>
                <div class="w-form-fail">
                    <div>Oops! Something went wrong while submitting the form.</div>
                </div>
            </form>
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