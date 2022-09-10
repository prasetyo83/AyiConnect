@extends('layouts.admin')

@section('title')
    Add New Feeling
@endsection
@section('content')
    <div class="reasonwrapper">
        <div class="reasonwrapper-copy">          
            <div class="reasoninput">  
                <div class="reason1">
                    <div class="w-form"> 
                        <form id="wf-form-feeling-form" name="wf-form-feeling-form" data-name="reason-form" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" id="action_add" value='add'>
                            <label class="field-label h1">Add New Feelings</label>                           
                             
                            <div class="input-group">
                                <label for="reason" class="teksti">Select Reason</label>
                                <select id="reason" name="reason" data-name="reason" required="" class="select2 w-select" data-placeholder="Select a reason">
                                    @foreach ($reasons as $item)
                                               <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-btn">
                                    <button data-toggle="modal" data-target="#addReasonModal" class="btn btn-outline-secondary" type="button"><i class="fa fa-plus fa-sm"></i></button>
                                </div>
                            </div>
                    </div>
                    <div class="w-form-done">
                        <div>Thank you! Your submission has been received!</div>
                    </div>
                    <div class="w-form-fail">
                        <div>Oops! Something went wrong while submitting the form.</div>
                    </div>
                </div>
                <div class="reason2">
                    <div class="w-form">                        
                            <label for="title" class="teksti">Name Feeling</label>
                            <input type="text" class="text-field-3 w-input" maxlength="256" name="title"
                                data-name="title" placeholder="Feeling name" id="title" required="">
                            <label for="img" class="teksti">Feeling Image</label>
                            <input type="file" class="w-input" name="img" data-name="img" placeholder="Example Text" id="img">
                    </div>    
                    <input type="submit" id="savedata" value="Create Feeling" class="button-3 w-button" />    
                </div>
                    
            </form> 
            </div>
           
        </div>
        <div class="reason-list">
            <div class="titujt">Feeling List</div>
            <div class="author-table">
              <table id="feeling_table" class="table table-striped table-bordered ajaxTable" style="width:100%">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Reason</th>
                          <th>Title</th>
                          <th>Image</th>
                          <th>Created At</th>
                          <th>Actions</th>                    
                      </tr>
                  </thead>        
              </table>
            </div>
          </div>
        
        <div class="modal fade" id='editFeelingModal' role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Feeling</h4>
                    </div>
                    <div class="modal-body">
                        <form id="update_feeling_form" method="POST" data-parsley-validate
                            enctype="multipart/form-data" class="form-horizontal form-label-left">

                            <input type="hidden" name="id" id="feeling_id" value=''>
                            <input type="hidden" name="action" data-action="action_update" value='edit'>
                            <div class="form-group">
                                <label for="reason" class="control-label col-md-3 col-sm-3 col-xs-12">Select Reason</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="select2-update-feeling" name="reason" data-name="reason"
                                        class="select2 w-select">
                                         @foreach ($reasons as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name Feeling: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="text" name="title" id="update_title"
                                        class="form-control" placeholder="Enter feeling name..." required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Feeling Image: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <div class="image"><img id="my_image" src="" height="50"
                                            width="50"></div>
                                    <p><b>Note: Leave it blank for no change.</b></p>
                                    <input type="hidden" name="hidden_image" id="hidden_image" value=''>
                                    <input type="file" name="img" id="update_image_name" class="form-control"
                                        placeholder="Enter reason image..">
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
                            <div id="update_reason_result"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        
        <div class="modal fade" id='addReasonModal' role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Reason Popup</h4>
                    </div>
                    <div class="modal-body">
                        <form id="reason_form" method="POST" data-parsley-validate
                            enctype="multipart/form-data" class="form-horizontal form-label-left">                           
                            <input type="hidden" name="action" data-action="action" value='add'>
                            <div class="form-group">
                                <label for="mood" class="control-label col-md-3 col-sm-3 col-xs-12">Select Mood</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="select2-update-mood" name="mood" data-name="mood"></select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name Reason: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="text" name="title" id="update_title"
                                        class="form-control" placeholder="Enter Categories Name..." required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Reason Image: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">                                   
                                    <input type="file" name="img" id="update_image_name" class="form-control"
                                        placeholder="Enter reason image..">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" id="add-submit-btn" class="btn btn-danger">Create Now</button>
                                </div>
                            </div>
                        </form>                        
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

        $(function(){ 
            $('#reason').select2({               
                placeholder: "Select reason", 
                ajax:{
                    url: "{{ route('showreason') }}",
                    type:'GET',
                    datatype:'json',    
                    delay:250,          
                    processResults:function(data){
                        return {
                            results:  $.map(data, function (item) {
                                    return {
                                      text: item.title,
                                      id: item.id
                                  }
                              })
                            };   
                    },
                    cache:true
                }
            });
            
           
            
            $('#select2-update-feeling').select2({
            dropdownParent: $("#editFeelingModal"),
            selectOnClose:true,
                ajax:{
                    url: "{{ route('showreason') }}",
                    type:'GET',
                    datatype:'json',    
                    delay:250,          
                    processResults:function(data){
                        return {
                            results:  $.map(data, function (item) {
                                    return {
                                      text: item.title,
                                      id: item.id
                                  }
                              })
                            };   
                    },
                    cache:true
                }
            });
            
            $('#select2-update-mood').select2({
            dropdownParent: $("#addReasonModal"),
            selectOnClose:true,
                ajax:{
                    url: "{{ route('showmood') }}",
                    type:'GET',
                    datatype:'json',    
                    delay:250,          
                    processResults:function(data){
                        return {
                            results:  $.map(data, function (item) {
                                    return {
                                      text: item.title,
                                      id: item.id
                                  }
                              })
                            };   
                    },
                    cache:true
                }
            });
            
            var table = $('#feeling_table').DataTable({
                dom: 'Bfrtip', 
                pageLength:25,
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('feeling.table') }}",
                columnDefs:[{
                        targets:[0,3,5],
                        className:'dt-body-center'
                }],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'reason', name: 'reason' },
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
        
        $('body').on('submit','#reason_form',function(e) {        
            e.preventDefault();
            var formData = new FormData(document.getElementById("reason_form")),
            dataAct = $(this).find('input:hidden[name=action]').val();
                       
            $.ajax({
                data: formData,
                url: "{{ route('reason.store')}}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {  
                    $('#reason_form').trigger("reset");
                    $("#select2-update-mood").val('').trigger('change');          
                    alert("Adding new reason success!");
                    $("#addReasonModal").modal('hide');
                },
                error: function(data) {
                    alert("Adding new reason failed!");
                    console.log('Error:', data);                    
                   
                }
            });
            
        });
     
       
        $('body').on('submit','#wf-form-feeling-form,#update_feeling_form',function(e) {        
            e.preventDefault();
            var formData = new FormData(this),
            dataAct = $(this).find('input:hidden[name=action]').val();            
            if (dataAct == 'add'){
                $("#savedata").html('Sending..');
            }
            
            $.ajax({
                data: formData,
                url: "{{ route('feeling.store')}}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {                    
                    if (dataAct == 'edit'){
                        $("#update_feeling_form").trigger("reset");
                        $("#select2-update-feeling").val('').trigger('change');                       
                        $('#editFeelingModal').modal('hide');
                    }else{
                        $('#wf-form-feeling-form').trigger("reset");
                        $("#reason").val('').trigger('change');
                        $('.w-form-done').show().delay(5000).fadeOut();
                    }   
                    
                    setTimeout(function() {
                        $('#feeling_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000); 
                },
                error: function(data) {
                    console.log('Error:', data);                    
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
            
        });
     
        
        
        $('body').on('click', 'a.delete-feeling',function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            var id = $(this).data("id");
            $.ajax({
                data: {"id":id},
                url: "{{ route('feeling.destroy', csrf_token()) }}",
                type: "DELETE",
                dataType: 'json',
                success: function(data) {                                       
                    $('.w-form-done').html(data['success']);
                    $('.w-form-done').show().delay(5000).fadeOut();
                    setTimeout(function() {
                        $('#feeling_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });            
        });
        
         $('body').on('click', 'a.edit-feeling', function(e) {
            e.preventDefault();          
            var id = $(this).data('id');            
                       
            $.ajax({
                data: {"id":id},
                url: "{{ route('feeling.edit', csrf_token()) }}",
                type: "GET",
                dataType: 'json',
                success: function(data) {                     
                    $('#feeling_id').val(data.id);
                    $('#update_title').val(data.title); 
                    $('#select2-update-feeling').select2().val(data.reason_id).trigger('change');
                    $('#hidden_image').val(data.image);
                    $('#my_image').attr('src', data.image);
                }
            });
        });   
</script>   
@endsection
