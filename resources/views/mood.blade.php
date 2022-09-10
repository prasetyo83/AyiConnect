@extends('layouts.admin')
@section('title')
    Moods
@endsection
@section('content')
  <div class="mood-wrapper">
    <div class="mood-input">
      <div class="form-block w-form">           
        <form id="wf-form-add-mood-form" class="form" name="wf-form-add-mood-form" data-name="new-mood-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action_add" value='add'>
            <label for="title" class="titujt">Mood</label>
            <input type="text" class="text-field w-input" maxlength="256" name="title" data-name="title" placeholder="" id="title" required="">
            <label for="img" class="teksti">Mood Image</label>
            <input type="file" class="w-input" name="img" data-name="img" placeholder="Example Text" id="img">
            <input id="savedata" type="submit" value="Submit" data-wait="Please wait..." id="add-mood-button" class="button-3 w-button">
        
        <div class="w-form-done">
          Thank you! Your submission has been received!
        </div>
        <div class="w-form-fail">
          Oops! Something went wrong while submitting the form.
        </div>
        </form>    
      </div>
    </div>
      
    <div class="modal fade" id='editMoodModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Mood</h4>
                </div>
                <div class="modal-body">
                    <form id="update_mood_form" method="POST" data-parsley-validate
                        enctype="multipart/form-data" class="form-horizontal form-label-left">
                        
                        <input type="hidden" name="id" id="mood_id" value=''>
                        <input type="hidden" name="action" data-action="action_update" value='edit'>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mood Title: </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <input type="text" name="title" id="update_mood_title"
                                    class="form-control" placeholder="Enter Mood Title..." required>
                            </div>
                        </div>                    
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mood Image: </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <div class="image"><img id="my_image" src="" height="50" width="50"></div>
                                <p><small>Note: Leave it blank for no change.</small></p>
                                <input type="hidden" name="hidden_image" id="hidden_image" value=''>
                                <input type="file" name="img" id="update_image_name" class="form-control"
                                    placeholder="Enter Mood file...">
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
                        <div id="update_mood_result"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class="mood-list">
      <div class="titujt">Mood List</div>
      <div class="author-table">
        <table id="mood_table" class="table table-striped table-bordered ajaxTable" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Actions</th>                    
                </tr>
            </thead>        
        </table>

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
            var table = $('#mood_table').DataTable({
                dom: 'Bfrtip', 
                pageLength:25,
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('mood.index') }}",
                columnDefs:[{
                        targets:[0,2,4],
                        className:'dt-body-center'
                }],
                columns: [
                    { data: 'id', name: 'id' },                    
                    { data: 'title', name: 'title' },
                    { data: 'image', name: 'image', render: function(url,type,full){
                            var img = (url == null) || (url == "") ? "<span style='font-style:italic;color:#DDDD;'>none</span>" : "<span><img width='32px' height='32px' src='"+url+"'></span>";
                            return img;
                    }},
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: 'actions', searchable: false}
                ],
                buttons:[{                       
                    extend: 'csvHtml5',
                    text:'<i class="fa fa-file-csv fa-lg"></i>',
                    titleAttr: 'Export to CSV',
                    exportOptions: {
                        modifier: {
                            page: 'all',
                            search : 'none'
                        }
                    }                      
                }, {
                    extend:'colvis',
                    text:'<i class="fa fa-th fa-lg"></i>',
                    titleAttr: 'Columns',
                }],    
                order: [
                    [0, 'asc']
                ]
            });
        });
        
        $('body').on('submit','#wf-form-add-mood-form,#update_mood_form',function(e) {
            e.preventDefault();
            var formData = new FormData(this),            
            dataAct = $(this).find('input:hidden[name=action]').val();
            
            if (dataAct == 'add'){
                $("#savedata").html('Sending..');
            }
            
            $.ajax({
                data: formData,
                url: "{{ route('mood.store') }}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {                    
                    if (dataAct == 'edit'){
                        $("#update_mood_form").trigger("reset");
                        $('#editMoodModal').modal('hide');
                    }else{
                        $('#wf-form-add-mood-form').trigger("reset");
                        $('.w-form-done').show().delay(5000).fadeOut();
                    }   
                    
                    setTimeout(function() {
                        $('#mood_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000); 
                },
                error: function(data) {
                    console.log('Error:', data);                    
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
            
        });
        
        
        $('body').on('click', 'a.delete-mood',function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            var id = $(this).data("id");
            $.ajax({
                data: {"id":id},
                url: "{{ route('mood.destroy', csrf_token()) }}",
                type: "DELETE",
                dataType: 'json',
                success: function(data) {                                       
                    $('.w-form-done').html(data['success']);
                    $('.w-form-done').show().delay(5000).fadeOut();
                    setTimeout(function() {
                        $('#mood_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });            
        });
        
         $('body').on('click', 'a.edit-mood', function() {
            var id = $(this).data('id');
                       
            $.ajax({
                data: {"id":id},
                url: "{{ route('mood.edit', csrf_token()) }}",
                type: "GET",
                dataType: 'json',
                success: function(data) {  
                    $('#mood_id').val(data.id);
                    $('#update_mood_title').val(data.title);
                    $('#hidden_image').val(data.image);
                    $('#my_image').attr('src', data.image);
                }
            }); 
        });
       
           
        
       
</script>   
@endsection
