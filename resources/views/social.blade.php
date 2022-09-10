@extends('layouts.admin')

@section('title')
    Social
@endsection
@section('content')
    <div class="section-wrapper">
        <div class="section-input">
            <div class="form-block w-form">
                <form id="wf-form-social-form" name="wf-form-social-form" data-name="social-form" method="post"
                    class="form">
                     <input type="hidden" name="action" data-action="action_add" value='add'>
                    <label for="social_name" class="titujt">Social Media</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="social_name" class="teksti">Name</label>
                    <input type="text"class="text-field w-input" maxlength="256" name="social_name" data-name="social_name" placeholder="" id="social_name" required="">                   
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="icon" class="teksti">Icon</label>
                    <input type="text"class="text-field w-input" maxlength="256" name="icon" data-name="icon" placeholder="" id="icon">                   
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-12">
                    <input id="savedata" type="submit" value="Create Social" data-wait="Please wait..."
                        id="create-social" class="button-3 w-button">
                  
                     <div class="w-form-done">
                    <div>Thank you! Your submission has been received!</div>
                    </div>
                    <div class="w-form-fail">
                        <div>Oops! Something went wrong while submitting the form.</div>
                    </div>
                    </div>
                </form>

               
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
                            <h2>Social Order Settings</h2>
                            <h4>Update Social Order here</h4>
                            <div class="clearfix"></div>
                        </div>
                        <table
                            class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-socialOrder">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        row_name
                                    </th>
                                    <th>
                                        Name
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
                    <div class="titujt">Social List </div>
                </div>
                <div class="col-lg-3">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="table-responsive">
                        <table id="social_table" class="table table-striped table-bordered ajaxTable">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Row Order
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Icon
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

    <div class="modal fade" id='editSocialModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Social Media</h4>
                </div>
                <div class="modal-body">
                    <form id="update_social_form" method="POST" data-parsley-validate
                        class="form-horizontal form-label-left">

                        <input type="hidden" name="id" id="social_id" value=''>
                        <input type="hidden" name="action" data-action="action_update" value='edit'>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="social_name" id="update_name" class="form-control text-field w-input"
                                    placeholder="Enter Section Name..." required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icon">Icon</label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="icon" id="update_icon" class="form-control text-field w-input">
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" id="update_submit_btn" class="btn btn-danger">Update Now</button>
                            </div>
                        </div>
                    </form>                   
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
        
        $(function(){
        
            var table = $('#social_table').DataTable({
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
                ajax: "{{ route('social.index') }}",
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
                        data: 'icon',
                        name: 'icon'
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
                    [1, 'desc']
                ]

            });
        });

          $('body').on('submit','#wf-form-social-form,#update_social_form',function(e) {
            e.preventDefault();
            var formData = new FormData(this),
            dataAct = $(this).find('input:hidden[name=action]').val();
            
            if (dataAct == 'add'){
                $("#savedata").html('Sending..');
            }
            
            $.ajax({
                data: formData,
                url: "{{ route('social.store') }}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(data) {
                    if (dataAct == 'add'){
                        $('#wf-form-social-form').trigger("reset");
                        $('.w-form-done').show().delay(5000).fadeOut();
                    }else{
                        $('#update-social-form').trigger("reset");
                        $('#editSocialModal').modal('hide');
                    }
                    setTimeout(function() {
                        $('#social_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
        });

        $('body').on('click', 'a.delete-social',function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            var id = $(this).data("id");
            $.ajax({
                data: {"id":id},
                url: "{{ route('social.destroy', csrf_token()) }}",
                type: "DELETE",
                dataType: 'json',
                success: function(data) {                                       
                    $('.w-form-done').html(data['success']);
                    $('.w-form-done').show().delay(5000).fadeOut();
                    setTimeout(function() {
                        $('#social_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });            
        });
        
        $('body').on('click', 'a.edit-social', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                data: {"id":id},
                url: "{{ route('social.edit', csrf_token()) }}",
                type: "GET",
                dataType: 'json',
                success: function(data) {                     
                    $('#social_id').val(data.id);
                    $('#update_name').val(data.name); 
                    $('#update_icon').val(data.icon);                     
                }
            });
        }); 
        
        
        let dtOverrideGlobals = {
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: "{{ route('social.index') }}",
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
                }
            ],
            order: [
                [1, 'asc']
            ],
            pageLength: 25,
            rowReorder: {
                selector: 'tr',
                dataSrc: 'row_order'
            },
        };
        
        //td:not(:first-of-type,:last-of-type)
        let datatable = $('.datatable-socialOrder').DataTable(dtOverrideGlobals);
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
                    url: "{{ route('socialreorder') }}",
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
