@extends('layouts.admin')
@section('title')
    System Settings
@endsection
@section('content')
    <div class="add-author">
        <div class="author-input">
            <div class="form-block w-form">
                <?php
                if (is_null($setting)) {
                    $data = '';
                } else {
                    if ($setting->type == 'system_configurations') {
                        $value = $setting->value;
                        $data = json_decode($value);
                    } else {
                        $value = '';
                    }
                }
                
                
                ?>
                <form id="wf-form-setting-form" name="wf-form-author-form" class="form" data-name="author-form" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" name="dif" value="system_configurations">
                    <label for="mood-name" class="titujt">System Configurations for App </label><small>Note that this will
                        directly reflect the changes in App</small><label for="author-name"
                        class="teksti">Description</label>
                    {{-- <input type="text" class="text-field w-input" maxlength="256" name="name" data-name="name"
                    placeholder="" id="author-name" required=""> --}}
                    <textarea name="app_description" id="app_description" class="text-field w-input">{{ $data!="" ? $data->app_description : '' }}</textarea>
                    <label for="author-name" class="teksti">
                        App Version</label>
                    <div id="app_version">

                        <input class=" text-field w-input" id="app_version" name="app_version" type="text"
                            value="{{ $data!="" ? $data->app_version : '' }}" placeholder="app version"
                            maxlength="256" />
                    </div>

                    <label for="name-image" class="teksti">Author </label><input type="text" class="text-field w-input"
                        name="app_author" data-name="author" placeholder="Example Text" id="app_author" required=""
                        value="{{ $data!="" ? $data->app_author : '' }}">
                    <label for="name-image" class="teksti">Contact </label><input type="text" class="text-field w-input"
                        name="app_contact" data-name="app_contact" placeholder="Example Text" id="app_contact"
                        required="" value="{{ $data!="" ? $data->app_contact : '' }}">
                    <label for="name-image" class="teksti">Email </label><input type="email" class="text-field w-input"
                        name="app_email" data-name="app_email" placeholder="Example Text" id="app_contact" required=""
                        value="{{ $data!="" ? $data->app_email : '' }}">

                    <input type="submit" value="Update Configuration" data-wait="Please wait..." id="savedata"
                        class="button-3 w-button">

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
        @parent
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('body').on('submit', '#wf-form-setting-form', function(e) {
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
                    // $('#wf-form-setting-form').trigger("reset");
                    $('.w-form-done').show().delay(5000).fadeOut();
                    // alert(JSON.stringify(data.value));
                    var a = JSON.parse(data.value);
                    // alert(a.app_version);

                    setTimeout(function() {
                        //     // $('#author_table').DataTable().ajax.reload(null, false);
                        //     // $('.ajaxTable').DataTable().ajax.reload(null, false);
                        $('#app_description').val(a.app_description);
                        $('#app_version').val(a.app_version);
                        $('#app_author').val(a.app_author);
                        $('#app_contact').val(a.app_contact);
                        $('#app_email').val(a.app_email);
                    }, 1000);

                },
                error: function(data) {
                    console.log('Error:', data);
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
        });
        tinymce.init({
            selector: '#app_description',
            height: 300,
            menubar: true,
            plugins: [
                'advlist autolink lists link charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime table contextmenu paste code help wordcount'
            ],
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            setup: function(editor) {
                editor.on("change keyup", function(e) {
                    //tinyMCE.triggerSave();
                    editor.save();
                    $(editor.getElement()).trigger('change');
                });
            }
        });
    </script>
@endsection
