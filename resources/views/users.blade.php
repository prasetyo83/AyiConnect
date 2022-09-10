@extends('layouts.admin')
@section('title')
    Users
@endsection
@section('content')
    <div class="div-block">
        <div class="users-list">
            <div class="titujt">Users List</div>
            <div class="table-responsive">
                <table id="users_table" class="table table-striped table-bordered ajaxTable">
                    <thead>
                        <tr>
                            <th>
                                id
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Surname
                            </th>
                            <th>
                                Age
                            </th>
                            <th>
                                Gender
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Country
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
        <div class="modal fade" id='moodModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Mood History</h4>
                    </div>
                    <div class="modal-body">
                        <div class="data-mood"></div>
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
        $(function() {
            var table = $('#users_table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csvHtml5',
                        text: '<i class="fa fa-file-csv" style="color: green;"></i> Export All to CSV',
                        exportOptions: {
                            columns: ':visible'
                        },
                        "titleAttr": 'CSV',
                        "action": newexportaction
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-th fa-lg"></i>',
                        titleAttr: 'Columns',
                    }
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'surname',
                        name: 'surname'
                    },
                    {
                        data: 'age',
                        name: 'age'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'country',
                        name: 'country'
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
            
            function newexportaction(e, dt, button, config) {                
                var self = this;
                var oldStart = dt.settings()[0]._iDisplayStart;
                dt.one('preXhr', function (e, s, data) {
                    // Just this once, load all data from the server...
                    data.start = 0;
                    data.length = 2147483647;
                    dt.one('preDraw', function (e, settings) {
                        // Call the original action function
                        if (button[0].className.indexOf('buttons-copy') >= 0) {
                            $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                            $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-csv') >= 0) {                            
                            window.location ="{{ route('users.export2csv', csrf_token()) }}";                            
                        } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                            $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                                $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-print') >= 0) {
                            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        }
                        dt.one('preXhr', function (e, s, data) {
                            // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                            // Set the property to what it was before exporting.
                            settings._iDisplayStart = oldStart;
                            data.start = oldStart;
                        });
                        // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                        setTimeout(dt.ajax.reload, 0);
                        // Prevent rendering of the full data to the DOM
                        return false;
                    });
                });
                // Requery the server with the new one-time export settings
                dt.ajax.reload();
            }

        });

        $('body').on('click', '.Mood', function() {
            var id = $(this).data('id');
            // alert(id);
            $.get("{{ route('user.index') }}" + '/' + id + '/edit', function(data) {
                // alert(data);
                $('#moodModal').modal('show');
                $('#moodModal .modal-body').html(data);
            })


        });
    </script>
@endsection
