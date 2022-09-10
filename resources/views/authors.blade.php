@extends('layouts.admin')
@section('title')
    Authors
@endsection
@section('content')
    <div class="add-author">
        <div class="author-input">
            <div class="form-block w-form">
                <form id="wf-form-author-form" name="wf-form-author-form" class="form" data-name="author-form" method="post"
                    enctype="multipart/form-data">
                    <label for="mood-name" class="titujt">Author</label><label for="author-name" class="teksti">Author
                        Name</label>
                    <input type="text" class="text-field w-input" maxlength="256" name="name" data-name="name"
                        placeholder="" id="author-name" required="">
                    <label for="author-name" class="teksti">
                        Hastag</label>

                    <select id="hastag" name="hastag[]" data-name="tag" class="select2 w-select"
                        data-placeholder="Select Hastag" multiple="multiple">


                    </select>

                    <label for="name-image" class="teksti">Image </label><input type="file" class="text-field w-input"
                        name="image" data-name="image" placeholder="Example Text" id="image">
                    <label class="w-checkbox premium-checkbox"><input type="checkbox" name="premium" id="checkbox"
                            data-name="premium" class="w-checkbox-input checkbox-3"><span class="checkbox-text w-form-label"
                            for="checkbox">Is Premium?</span></label>
                    <input type="submit" value="Add Author" data-wait="Please wait..." id="savedata"
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
        <div class="author-list">
            <div class="right_col" role="main">
                <!-- top tiles -->
                <br />
                <div class="author-table">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Author Order Settings</h2>
                            <h3>Update Author Order here</h3>
                            <div class="clearfix"></div>
                        </div>
                        <table
                            class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-authorOrder">
                            <thead>
                                <tr>

                                    <th>
                                        id
                                    </th>
                                    <th>
                                        row_name
                                    </th>
                                    <th>
                                        Author Name
                                    </th>
                                    <th>
                                        premium
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>

                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="author-list">
            <div class="row">
                <div class="col-lg-9">
                    <div class="titujt">Author List </div>
                </div>
                <div class="col-lg-3">

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="table-responsive">
                        <table id="author_table" class="table table-striped table-bordered ajaxTable">
                            <thead>
                                <tr>
                                    <th>
                                        id
                                    </th>
                                    <th>
                                        Row Order
                                    </th>
                                    <th>
                                        Author Name
                                    </th>
                                    <th>
                                        Image
                                    </th>
                                    <th>
                                        IsPremium
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
        </div>
    </div>
    <div class="modal fade" id='editAuthorModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Author</h4>
                </div>
                <div class="modal-body">
                    <form id="update_author_form" method="POST" data-parsley-validate
                        class="form-horizontal form-label-left" enctype="multipart/form-data">

                        <input type="hidden" name="id" id="author_id" value=''>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Author Name: </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="name" id="update_author_name" class="form-control"
                                    placeholder="Enter Author Name..." required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Image: </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <div class="image"><img id="my_image" src="" height="50" width="50">
                                </div>
                                <p><b>Note: Leave it blank for no change.</b></p>
                                <input type="hidden" name="hidden_image" id="hidden_image" value=''>
                                <input type="file" name="image" id="update_image_name" class="form-control"
                                    placeholder="Enter Section Name...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tags: </label>
                            <input type="hidden" id="deltag" name="deltag" />
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                {{-- <div id="tags1">
                                    <input type="hidden" id="hastag1" name="hastag" />
                                    <input type="hidden" id="deltag" name="deltag" />
                                    <input class=" text-field w-input" id="tag1" type="text" value=""
                                        placeholder="Add a tag" maxlength="256" />
                                </div> --}}
                                <select id="hastag1" name="hastag[]" data-name="tag" class="select2 w-select"
                                    data-placeholder="Select Hastag" multiple="multiple">
                                    @foreach ($hastags as $hastag)
                                        <option value="{{ $hastag->id }}">{{ $hastag->hastag }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="premium">isPremium <i
                                    class='fas fa-gem blue'></i>:</label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="checkbox" name="premium" id="update_premium" class="form-check-input">
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
                        <div id="update_author_result"></div>
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
        var dtag = "";
        var nTag = false;
        var term = "";
        var lastHastagId = {{ App\Models\Hastag::max('id') ? App\Models\Hastag::max('id') : 0 }};
        $(function() {
            var table = $('#author_table').DataTable({
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
                ajax: "{{ route('authors.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'row_order',
                        name: 'row_order',
                        visible: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'premium',
                        name: 'premium'
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
                    [0, 'asc']
                ],

            });



        });

        $('body').on('submit', '#wf-form-author-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var actionType = $('#btn-save').val();
            $('#savedata').html('Sending..');
            $.ajax({
                data: formData,
                url: "{{ route('authors.store') }}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    $('#wf-form-author-form').trigger("reset");
                    $('.w-form-done').show().delay(5000).fadeOut();
                    setTimeout(function() {
                        $('#author_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
        });

        $('body').on('submit', '#update_author_form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var actionType = $('#btn-save').val();
            $('#savedata').html('Sending..');
            $.ajax({
                data: formData,
                url: "{{ route('authors.store') }}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    // $('#update_author_form').trigger("reset");
                    $('.w-form-done').show().delay(5000).fadeOut();
                    $('#editAuthorModal').modal('hide');
                    // $(this).html('Update Now');
                    // $('#section_table').bootstrapTable('refresh');
                    setTimeout(function() {
                        $('#author_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log(data);
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
        });
        $('body').on('click', '.delete-author', function() {
            var id = $(this).data("id");
            confirm("Are You sure want to delete this Post!");
            $.ajax({
                type: "DELETE",
                url: "{{ route('authors.store') }}" + '/' + id,
                success: function(data) {
                    setTimeout(function() {
                        $('#author_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });
        $('body').on('click', '.edit-auth', function() {

            var id = $(this).data('id');
            // alert(id);
            var sp = "";
            $.get("{{ route('authors.index') }}" + '/' + id + '/edit', function(data) {
                // alert(data.id);
                $('#author_id').val(data.id);
                $('#update_author_name').val(data.name);
                if (data.premium == "1") {
                    $('#update_premium').prop('checked', true);
                } else {
                    $('#update_premium').prop('checked', false);
                }
                const a = [];

                var i = 0;
                for (var dt of data.authorhastag) {

                    a[i] = dt.hastag.id;
                    i++;
                }
                // alert(a[1]);
                $('#hastag1').val(a);
                // // $("#update_section_id").select2("val", data.section_id);
                $('#hastag1').select2().trigger('change');
                // $(sp).insertBefore("#tags1 #tag1");
                $('#hidden_image').val(data.image);
                $('#my_image').attr('src', '/storage/author/' + data.image);
            })


        });

        $('body').on('click', '.detail-author', function() {
            var id = $(this).data('id');

            $.ajax({
                url: " {{ route('authordetails.index') }}",
                method: "GET",
                data: {
                    'id': id
                },
            });

        });

        let dtOverrideGlobals = {

            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: "{{ route('authors.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'row_order',
                    name: 'row_order',
                    visible: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'premium',
                    name: 'premium'
                },
                {
                    data: 'operate',
                    name: 'operate',
                    visible: false,
                    searchable: false
                }


            ],
            order: [
                [1, 'asc']
            ],
            pageLength: 10,
            rowReorder: {
                selector: 'tr td:not(:first-of-type,:last-of-type)',
                dataSrc: 'row_order'
            },
        };

        let datatable = $('.datatable-authorOrder').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        datatable.on('row-reorder', function(e, details) {
            if (details.length) {
                let rows = [];
                details.forEach(element => {
                    rows.push({
                        id: datatable.row(element.node).data().id,
                        position: element.newData
                    });
                });
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: "{{ route('authorreorder') }}",
                    data: {
                        rows
                    }
                }).done(function() {
                    datatable.ajax.reload()

                });
            }
        });

        function newtag(params, data) {
            var term = $.trim(params.term);
            if (term === '') {
                return null;
            }
            return {
                id: term,
                text: term ,
                newTag: true // add additional parameters
            }
        }

        function matchCustom(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }

            // Return `null` if the term should not be displayed
            return null;
        }

        $('#hastag').select2({
            placeholder: "Select Hastag",
            tags: true,
            tokenSeparators: [','],
            createTag: newtag,
            matcher: matchCustom,
            ajax: {
                url: "{{ route('getHastag') }}",
                type: "GET",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.hastag,
                                id: item.id
                            }
                        })
                    };
                   

                },
                cache: true
            }
        });



        $('#hastag1').select2({
            placeholder: "Select Hastag",
            tags: true,
            createTag: function(params) {
                console.log('mydata:' + JSON.stringify(params));
                var term = $.trim(params.term);

                if ((term === '' && term.length > 3)) {
                    return null;
                }

               
                return {
                    id: lastHastagId + 1,
                    text: term,
                    newTag: true // add additional parameters
                }
            },
            insertTag: function(data, tag) {
                data.push(tag);
            },
            ajax: {
                url: "{{ route('getHastag') }}",
                type: "GET",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    //   alert(JSON.stringify(data));
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.hastag,
                                id: item.id
                            }
                        })
                    };

                },
                cache: true
            }
        });

        
        $('#hastag').on('select2:select', function(e) {
           
            let tag = e.params.data;
            // alert(tag.newTag);
            if (tag.newTag === true) { //save newmood into table                
                // alert("disini kudiam");
                axios.post("{{ route('storeHastag') }}", {
                    id: tag.id,
                    hastag: tag.text
                });

            }
        });

        $('#hastag1').on('select2:unselect', function(e) {
            let tag = e.params.data;
            // tag = JSON.parse(tag);
            // alert(tag.id);
            dtag = tag.id + "," + dtag;
            $("#deltag").val(dtag);
        });


        // ==========================
    </script>
@endsection
