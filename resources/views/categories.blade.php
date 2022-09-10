@extends('layouts.admin')
@section('title')
    Categories
@endsection
@section('content')
    <div class="category-wrapper">
        <div class="input-wraper-copy">
            <div class="category-input">
                <div class="category">
                    <div class="w-form">
                        <form id="wf-form-category-form" name="wf-form-category-form" data-name="category-form" method="post"
                            enctype="multipart/form-data"><label for="category-select" class="titujt">Category</label><label
                                for="category-name" class="teksti">Category Name</label><input type="text"
                                class="w-input" maxlength="256" name="name" data-name="name" placeholder="Example Text"
                                id="name" required=""><label for="image-select" class="teksti">Category
                                ICon</label><input type="text" class="w-input" maxlength="256" name="icon"
                                data-name="icon" placeholder="Input icon name" id="icon"><label for="section-select"
                                class="teksti">Section</label><select id="section_id" name="section_id"
                                data-name="section_id" class="select2 w-select" data-placeholder="Select a section">
                                {{-- @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                @endforeach --}}
                                {{-- <option value="add">Add more section</option> --}}

                            </select>
                            <input type="hidden" id="newSession" name="newSession" value="">
                    </div>
                </div>
                <div class="category2">
                    <div class="w-form">
                        <label for="name-image" class="teksti">Image Name</label><input type="file" class="w-input"
                            name="image" data-name="image" placeholder="Example Text" id="image"><label
                            class="w-checkbox premium-checkbox"><input type="checkbox" name="premium" id="checkbox"
                                data-name="premium" class="w-checkbox-input checkbox-3"><span
                                class="checkbox-text w-form-label" for="checkbox">Is Premium?</span></label>
                        <div class="w-form-done">
                            <div>Thank you! Your submission has been received!</div>
                        </div>
                        <div class="w-form-fail">
                            <div>Oops! Something went wrong while submitting the form.</div>
                        </div>
                    </div>
                    <input type="submit" id="savedata" value="Create Category" class="button-3 w-button" />
                    </form>
                </div>
            </div>
            <a href="#" class="button w-button">Save</a>
        </div>
        <div class="category-list">
            <!-- page content -->
            <div class="right_col" role="main">
                <!-- top tiles -->
                <br />
                <div class="category-table">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>category Order Settings</h2>
                            <h3>Update category Order here</h3>
                            <div class="clearfix"></div>
                        </div>
                        <table
                            class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-categoryOrder">
                            <thead>
                                <tr>

                                    <th>
                                        id
                                    </th>
                                    <th>
                                        row_order
                                    </th>
                                    <th>
                                        Name
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
        <div class="category-list">
            <div class="row">
                <div class="col-lg-9">
                    <div class="titujt">category List </div>
                </div>
                <div class="col-lg-3">

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="table-responsive">
                        <table id="category_table" class="table table-striped table-bordered ajaxTable">
                            <thead>
                                <tr>
                                    <th>
                                        id
                                    </th>
                                    <th>
                                        Row Order
                                    </th>
                                    <th>
                                        Section Name
                                    </th>
                                    <th>
                                        Category Name
                                    </th>
                                    <th>
                                        Image
                                    </th>
                                    <th>
                                        Icon
                                    </th>

                                    <th>
                                        Quoted
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
        <div class="modal fade" id='editCategoriesModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Categories</h4>
                    </div>
                    <div class="modal-body">
                        <form id="update_categories_form" method="POST" data-parsley-validate
                            enctype="multipart/form-data" class="form-horizontal form-label-left">

                            <input type="hidden" name="id" id="categories_id" value=''>


                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="text" name="name" id="update_categories_name"
                                        class="form-control" placeholder="Enter Categories Name..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Section Name: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="section_id1" name="section_id" data-name="section_id"
                                        class="select2 w-select form-control">
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->text }}</option>
                                        @endforeach



                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Image: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <div class="image"><img id="my_image" src="" height="50"
                                            width="50"></div>
                                    <p><b>Note: Leave it blank for no change.</b></p>
                                    <input type="hidden" name="hidden_image" id="hidden_image" value=''>
                                    <input type="file" name="image" id="update_image_name" class="form-control"
                                        placeholder="Enter Section Name...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Icon: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="text" name="icon" id="update_icon" class="form-control"
                                        placeholder="Enter Icon..." >
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
                                    <button type="submit" id="update_submit_btn" class="btn btn-danger">Update
                                        Now</button>
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
        {{-- <div class="modal fade" id='addSectionModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Sections</h4>
                    </div>
                    <div class="modal-body">
                        <form id="add_section_form" method="POST" data-parsley-validate
                            class="form-horizontal form-label-left">



                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Section Name: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="text" name="section_name" id="section_name" class="form-control"
                                        placeholder="Enter Section Name..." required>
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
                                    <button type="submit" id="add_section_btn" class="btn btn-danger">Save Now</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div id="update_section_result"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
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
        var tag = false;
        // ================================
        var lastSectionId = {{ App\Models\Section::max('id') }};
        $('#section_id1').select2({
            dropdownParent: $("#editCategoriesModal"),
            selectOnClose: true,
            ajax: {
                url: "{{ route('show_section') }}",
                type: 'GET',
                datatype: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.title,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        //    =============
        $('body').on('submit', '#wf-form-category-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var actionType = $('#btn-save').val();
            $('#savedata').html('Sending..');
            $.ajax({
                data: formData,
                url: "{{ route('categories.store') }}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    $('#wf-form-category-form').trigger("reset");
                    $('.w-form-done').show().delay(5000).fadeOut();
                    setTimeout(function() {
                        $('#category_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
        });
        // ===========

        // ===================== 
        $('body').on('click', '.edit-categories', function() {
            var id = $(this).data('id');
            $.get("{{ route('categories.index') }}" + '/' + id + '/edit', function(data) {
                // alert(data.id);
                $('#categories_id').val(data.id);
                $('#update_categories_name').val(data.name);
                $('#hidden_image').val(data.image);
                // $('[name=section_id]').val(data.section_id);
                // alert();
                $('#section_id1').val(data.section_id);
                // // $("#update_section_id").select2("val", data.section_id);
                $('#section_id1').select2().trigger('change');
                $('#my_image').attr('src', '/storage/categories/' + data.image);
                $('#update_icon').val(data.icon);
                if (data.premium == "1") {

                    $('#update_premium').prop('checked', true);

                } else {
                    $('#update_premium').prop('checked', false);
                }
            })


        });

        function coba(params, data) {
            alert("asas");
        }
        // ==================
        // =================
        function newtag(params, data) {
            var term = $.trim(params.term);
            // alert(JSON.stringify(data));

            if (term === '') {
                // alert("coba aja ya");
                return null;
            }
            tag = false;
            // alert(lastSectionId);
            return {
                // test : coba,
                id: term,
                text: term,
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

        $('#section_id').select2({
            placeholder: "Select Section",
            tags: true,
            tokenSeparators: [','],
            createTag: newtag,
            matcher: matchCustom,
            ajax: {
                url: "{{ route('show_section') }}",
                type: "GET",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.section_name,
                                id: item.id
                            }
                        })
                    };


                },
                cache: true
            }
        });

        // $('#section_id').select2({
        //     placeholder: "Select Sections",
        //     tags: true,
        //     createTag: function(params) {
        //         console.log('mydata:' + JSON.stringify(params));
        //         var term = $.trim(params.term);

        //         if ((term === '' && term.length > 3)) {
        //             return null;
        //         }

        //         var lastSectionId = {{ App\Models\Section::max('id') }};
        //         return {
        //             id: lastSectionId + 1,
        //             text: term,
        //             newTag: true // add additional parameters
        //         }
        //     },
        //     insertTag: function(data, tag) {
        //         data.push(tag);
        //     },
        //     ajax: {
        //         url: "{{ route('show_section') }}",
        //         type: "GET",
        //         dataType: 'json',
        //         delay:250,
        //         processResults: function(data) {
        //         //   alert(JSON.stringify(data));
        //             return {
        //                     results:  $.map(data, function (item) {
        //                             return {
        //                               text: item.section_name,
        //                               id: item.id
        //                           }
        //                       })
        //                     }; 

        //         },
        //         cache: true
        //     }
        // });
        $('#section_id').on('select2:select', function(e) {
            let tag = e.params.data;
            if (tag.newTag === true) { //save newmood into table    
                // tag = true;
                $("#newSession").val("true");
                axios.post("{{ route('sections.store') }}", {
                    id: tag.id,
                    section_name: tag.text
                });

            }
        });

        $('#section_id1').select2({
            ajax: {
                url: '{{ route('show_section') }}',
                type: "get",
                dataType: 'json',

                processResults: function(data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    console.log(data);
                    data.push(test);
                    return {
                        results: data
                    };
                    cache: true
                }

            }
        });
        // =======================
        //====================
        $('body').on('click', '.delete-categories', function() {
            // alert('coba');
            var id = $(this).data("id");
            confirm("Are You sure want to delete this Post!");
            $.ajax({
                type: "DELETE",
                url: "{{ route('categories.store') }}" + '/' + id,
                success: function(data) {
                    setTimeout(function() {
                        $('#category_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });
        //========================
        // ====================
        $('body').on('submit', '#update_categories_form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var actionType = $('#btn-save').val();
            $('#savedata').html('Sending..');

            $.ajax({
                data: formData,
                url: "{{ route('categories.store') }}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    $('#update_categories_form').trigger("reset");
                    $('.w-form-done').show().delay(5000).fadeOut();
                    $('#editCategoriesModal').modal('hide');
                    $(this).html('Update Now');
                    // $('#section_table').bootstrapTable('refresh');
                    setTimeout(function() {
                        $('#category_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log(data);
                    // alert(data->error());
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
        });
        // =======================
        $(function() {
            var table = $('#category_table').DataTable({
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
                ajax: "{{ route('categories.index') }}",
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
                        data: 'section_name',
                        name: 'section_name'
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
                        data: 'icon',
                        name: 'icon'
                    },
                    {
                        data: 'quoted',
                        name: 'quoted'
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



        // ==========================
        let dtOverrideGlobals = {

            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: "{{ route('categories.index') }}",
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
            pageLength: 100,
            rowReorder: {
                selector: 'tr td:not(:first-of-type,:last-of-type)',
                dataSrc: 'row_order'
            },
        };

        let datatable = $('.datatable-categoryOrder').DataTable(dtOverrideGlobals);
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
                    url: "{{ route('categoriesreorder') }}",
                    data: {
                        rows
                    }
                }).done(function() {
                    datatable.ajax.reload()

                });
            }
        });

        // ===================
    </script>
@endsection
