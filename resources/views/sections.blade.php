@extends('layouts.admin')

@section('title')
    Sections
@endsection
@section('content')
    <div class="section-wrapper">
        <div class="section-input">
            <div class="form-block w-form">
                <form id="wf-form-section-form" name="wf-form-section-form" data-name="section-form" method="get"
                    class="form"><label for="name-section" class="titujt">Add New Section</label><input type="text"
                        class="text-field w-input" maxlength="256" name="section_name" data-name="section_name"
                        placeholder="" id="section_name" required=""><label id="premium-section"
                        class="w-checkbox premium-checkbox"><input type="checkbox" name="premium" id="checkbox"
                            data-name="Checkbox" class="w-checkbox-input checkbox-2"><span
                            class="checkbox-text w-form-label" for="checkbox">Is Premium?</span></label>
                    <input id="savedata" type="submit" value="Create Section" data-wait="Please wait..."
                        id="create-section" class="button-3 w-button">
                </form>

                <div class="w-form-done">
                    <div>Thank you! Your submission has been received!</div>
                </div>
                <div class="w-form-fail">
                    <div>Oops! Something went wrong while submitting the form.</div>
                </div>
            </div>
        </div>
        <div class="section-list">
            <!-- page content -->
            <div class="right_col" role="main">
                <!-- top tiles -->
                <br />
                <div class="section-table">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Section Order Settings</h2>
                            <h3>Update Section Order here</h3>
                            <div class="clearfix"></div>
                        </div>
                        <table
                            class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-sectionOrder">
                            <thead>
                                <tr>

                                    <th>
                                        id
                                    </th>
                                    <th>
                                        row_name
                                    </th>
                                    <th>
                                        Section Name
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
        <div class="section-list">
            <div class="row">
                <div class="col-lg-9">
                    <div class="titujt">Section List </div>
                </div>
                <div class="col-lg-3">

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="table-responsive">
                        <table id="section_table" class="table table-striped table-bordered ajaxTable">
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
                                        IsPremium
                                    </th>
                                    <th>
                                        Date Created
                                    </th>
                                    <th>
                                        Operate
                                    </th>



                                    public function setGoogle2faSecretAttribute($value)
    {
         $this->attributes['google2fa_secret'] = encrypt($value);
    }

    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }  </tr>
                            </thead>
                            <tbody>



                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id='editSectionModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Sections</h4>
                </div>
                <div class="modal-body">
                    <form id="update_section_form" method="POST" data-parsley-validate
                        class="form-horizontal form-label-left">

                        <input type="hidden" name="id" id="section_id" value=''>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Section Name: </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="section_name" id="update_section_name" class="form-control"
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
    
@endsection
@section('script')
    <script>
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {
            var table = $('#section_table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csvHtml5',
                        text:'<i class="fa fa-file-csv fa-lg"></i>',
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
                ajax: "{{ route('sections.index') }}",
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

        $('#savedata').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#wf-form-section-form').serialize(),
                url: "{{ route('sections.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#wf-form-section-form').trigger("reset");
                    $('.w-form-done').show().delay(5000).fadeOut();
                    setTimeout(function() {
                        $('#section_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
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
                data: $('#update_section_form').serialize(),
                url: "{{ route('sections.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#update_section_form').trigger("reset");
                    $('.w-form-done').show().delay(5000).fadeOut();
                    $('#editSectionModal').modal('hide');
                    $(this).html('Update Now');
                    // $('#section_table').bootstrapTable('refresh');
                    setTimeout(function() {
                        $('#section_table').DataTable().ajax.reload(null, false);
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
        $('body').on('click', '.delete-section', function() {
            // alert('coba');
            var id = $(this).data("id");
            confirm("Are You sure want to delete this Post!");
            $.ajax({
                type: "DELETE",
                url: "{{ route('sections.store') }}" + '/' + id,
                success: function(data) {
                    setTimeout(function() {
                        $('#section_table').DataTable().ajax.reload(null, false);
                        // $('#section_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });
        $('body').on('click', '.edit-section', function() {
            var id = $(this).data('id');
            $.get("{{ route('sections.index') }}" + '/' + id + '/edit', function(data) {
                // alert(data.id);
                $('#section_id').val(data.id);
                $('#update_section_name').val(data.section_name);
                if (data.premium == "1") {

                    $('#update_premium').prop('checked', true);

                } else {
                    $('#update_premium').prop('checked', false);
                }
            })


        });

        let dtOverrideGlobals = {

            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: "{{ route('sections.index') }}",
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

        let datatable = $('.datatable-sectionOrder').DataTable(dtOverrideGlobals);
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
                    url: "{{ route('sectionreorder') }}",
                    data: {
                        rows
                    }
                }).done(function() {
                    datatable.ajax.reload()

                });
            }
        });
    </script>
@endsection
