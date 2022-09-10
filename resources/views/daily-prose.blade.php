@extends('layouts.admin')
@section('title')
    Add Daily Prose
@endsection
@section('content')
    <div class="prose-content">
        <div class="input-wraper">
            <div class="quote-copy">
                <div class="w-form">
                    <form id="wf-form-daily-form" name="wf-form-quote-form" data-name="quote form" method="post" class="form-3">
                        <label for="From-Book-2" class="teksti">Mood</label><select id="mood_id" name="mood_id"
                            data-name="From Book 2" class="select2 w-select">
                            @foreach ($moods as $mood)
                            <option value="{{ $mood->id }}">{{ $mood->title }}</option>
                        @endforeach
                        </select>
                        <label for="Author-2" class="teksti">Author</label><select id="author_id" name="author_id"
                            data-name="Author 2" class="select2 w-select">
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                        <label for="field-2" class="titujt">Prose</label>
                        <textarea id="prose" name="prose" maxlength="5000" data-name="Field 2" placeholder="Example Text" required=""
                            class="textarea w-input"></textarea>
                        <input id="savedata" type="submit" value="Add Prose" data-wait="Please wait..." id="create-prose"
                            class="button-3 w-button">
                    </form>
                    <div class="w-form-done">
                        <div>Thank you! Your submission has been received!</div>
                    </div>
                    <div class="w-form-fail">
                        <div>Oops! Something went wrong while submitting the form.</div>
                    </div>

                </div>
            </div>
        </div>
        <div class="prose-list">
            <div class="titujt">Prose List</div>
            <div class="quote-table">
                <div class="table-responsive">
                    <table id="prose_table" class="table table-striped table-bordered ajaxTable">
                        <thead>
                            <tr>
                                <th>
                                    id
                                </th>
                                <th>
                                    Mood
                                </th>
                                <th>
                                    Author
                                </th>
                                <th>
                                    Prose
                                </th>
                                <th>
                                    Date Created
                                </th>
                                <th>
                                    Operate
                                </th>



                            </tr>
                        </thead>
                        <tbody>



                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id='editDailyModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Sections</h4>
                    </div>
                    <div class="modal-body">
                        <form id="update_daily_form" method="POST" data-parsley-validate
                            class="form-horizontal form-label-left">

                            <input type="hidden" name="id" id="daily_id" value=''>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Mood : </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="mood_update" name="mood_id" data-name="mood_id"
                                        class="select2 w-select form-control">
                                        @foreach ($moods as $mood)
                                            <option value="{{ $mood->id }}">{{ $mood->title }}</option>
                                        @endforeach



                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Author : </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="author_update" name="author_id" data-name="author"
                                        class="select2 w-select form-control">
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                                        @endforeach



                                    </select>
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="premium">Prose :</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <textarea id="prose_update" name="prose" maxlength="5000" data-name="Field 2" placeholder="Example Text" required=""
                            class="textarea w-input"></textarea>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" id="update_submit_btn" class="btn btn-danger">Update Now</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div id="update_section_result"></div>
                        </div>
                    </div>
                </div>
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
        $('#mood_id').select2()
        $('#author_id').select2()
        $(function() {
            var table = $('#prose_table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csvHtml5',
                        text: '<i class="fa fa-file-csv fa-lg"></i>',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-th fa-lg"></i>',
                        titleAttr: 'Columns',
                    }
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('dailyprose.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'mood',
                        name: 'mood',

                    },
                    {
                        data: 'author',
                        name: 'author'
                    },
                    {
                        data: 'prose',
                        name: 'prose'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'operate',
                        name: 'operate',
                        orderable: false,
                        searchable: false
                    },

                ],
                order: [
                    [4, 'asc']
                ],

            });



        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#wf-form-daily-form').serialize(),
                url: "{{ route('dailyprose.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#wf-form-daily-form').trigger("reset");
                    $('.w-form-done').show().delay(5000).fadeOut();
                    setTimeout(function() {
                        $('#prose_table').DataTable().ajax.reload(null, false);;
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
        });

        $('#update_submit_btn').click(function(e) {
            e.preventDefault();


            $.ajax({
                data: $('#update_daily_form').serialize(),
                url: "{{ route('dailyprose.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#update_daily_form').trigger("reset");
                    $('.w-form-done').show().delay(5000).fadeOut();
                    $('#editDailyModal').modal('hide');
                    $(this).html('Update Now');
                    // $('#section_table').bootstrapTable('refresh');
                    setTimeout(function() {
                        $('#prose_table').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log(data);
                    // alert(data->error());
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
        });
        $('body').on('click', '.delete-daily', function() {
            // alert('coba');
            var id = $(this).data("id");
            confirm("Are You sure want to delete this Prose!");
            $.ajax({
                type: "DELETE",
                url: "{{ route('dailyprose.store') }}" + '/' + id,
                success: function(data) {
                    setTimeout(function() {
                        $('#prose_table').DataTable().ajax.reload(null, false);
                        // $('#section_table').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });
        $('body').on('click', '.edit-daily', function() {
            var id = $(this).data('id');
            $.get("{{ route('dailyprose.index') }}" + '/' + id + '/edit', function(data) {
                // alert(data.id);
                $('#daily_id').val(data.id);
                $('#prose_update').val(data.prose);
                $('#author_update').val(data.author_id);
                // // $("#update_section_id").select2("val", data.section_id);
                $('#author_update').select2().trigger('change');
                $('#mood_update').val(data.mood_id);
                // // $("#update_section_id").select2("val", data.section_id);
                $('#mood_update').select2().trigger('change');
            })


        });
    </script>
@endsection
