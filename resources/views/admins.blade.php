@extends('layouts.admin')
@section('title')
Users Backend
@endsection
@section('content')
<div class="div-block">
    <div class="users-list">
        <div class="titujt">Users Backend || <a href="{{route('index_newadmin')}}" class="btn btn-primary">New User Backend</a> </div>

        <div class="table-responsive">
            <table id="admins_table" class="table table-striped table-bordered ajaxTable">
                <thead>
                    <tr>
                        <th>
                            id
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Username
                        </th>
                        <th>
                            Company Name
                        </th>
                        <th>
                            IsAdmin
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">QR Code and Code GVerivacator</h4>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
        var table = $('#admins_table').DataTable({
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
            ajax: "{{ route('admin.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name',

                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'isadmin',
                    name: 'isadmin'
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
    $('body').on('click', '.delete-Users', function() {
            // alert('coba');
            var id = $(this).data("id");
            confirm("Are You sure want to delete this Post!");
            $.ajax({
                type: "DELETE",
                url: "{{ route('admin.store') }}" + '/' + id,
                success: function(data) {
                    setTimeout(function() {
                        $('#admins_table').DataTable().ajax.reload(null, false);
                        // $('#section_table').DataTable().ajax.reload(null, false);
                        
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });
        $('body').on('click', '.Mood', function() {
            var id = $(this).data('id');
            // alert(id);
            $.get("{{ route('admin.index') }}" + "/" + id + "/edit", function(data) {
                // alert(data);
                $('#moodModal').modal('show');
                $('#moodModal .modal-body').html(data);
            })


        });
</script>
@endsection