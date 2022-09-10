@extends('layouts.admin')
@section('title')
    Change Password
@endsection
@section('content')
    <div class="add-author">
        <div class="author-input">
            <div class="form-block w-form">

                <form id="password_form" name="wf-form-author-form" class="form" data-name="author-form" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" name="dif" value="password">

                    <input type="hidden" name="name" id="name" value="{{ Session::get('name') }}">
                    <label for="name-image" class="teksti">Old Password </label><input type="password"
                        class="text-field w-input" name="old_password" data-name="old_password" placeholder="Insert old password"
                        id="old_password" required="" value="">
                        <label class="teksti" id="old_status"></label>
                    <label for="name-image" class="teksti">New Password </label><input type="password"
                        class="text-field w-input" name="new_password" data-name="new_password" placeholder="Insert new password"
                        id="new_password" required="" value="">
                    <label for="name-image" class="teksti">Confrim Password </label><input type="password"
                        class="text-field w-input" name="confirm_password" data-name="confirm_password"
                        placeholder="retype new password" id="confirm_password" required="" value="">

                    <input type="submit" value="Change Password" data-wait="Please wait..." id="savedata"
                        class="button-3 w-button">

                    <div class="w-form-done">
                        <div>Thank you! Your Password has been changed!</div>
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
        @parent
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('body').on('submit', '#password_form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var actionType = $('#btn-save').val();
            $('#savedata').html('Sending..');
            $.ajax({
                data: formData,
                url: "{{ route('setting.store') }}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    $('#password_form').trigger("reset");
                    $('.w-form-done').show().delay(5000).fadeOut();
                    $('#old_status').html('');

                    

                },
                error: function(data) {
                    console.log('Error:', data);
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
        });
        $('#password_form').validate({
            rules: {
                old_password: "required",
                new_password: {
                    minlength: 6
                },
                confirm_password: {
                    minlength: 6,
                    equalTo: "#new_password"
                }
            }
        });
        $('#old_password').on('input', function() {
            var old_password = $(this).val();
            var name= $("#name").val();
            if (old_password.length > 4) {
                // alert(old_password);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('setting.store') }}',
                    data: { old_password: old_password, name: name },
                    beforeSend: function() {
                        $('#old_status').html('checking..');
                    },
                    success: function(result) {
                        // alert(result);
                        if (result.state='fail')
                        {
                            $('#old_status').html(result.data);
                        }
                        else
                        {
                            $('#old_status').html(result.data);
                        }
                       
                    }
                });
            }
        });
    </script>
@endsection
