@extends('layouts.admin')

@section('title')
    Add New Reason
@endsection
@section('content')
    <div class="reasonwrapper">
        <div class="reasonwrapper-copy">          
            <div class="reasoninput">  
                <div class="reason1">
                    <div class="w-form"> 
                        <form id="wf-form-reason-form" name="wf-form-reason-form" data-name="reason-form" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" id="action_add" value='add'>
                            <label class="field-label h1">Add New Reasons</label>
                            <label for="mood" class="teksti">Select Mood</label>
                            <select id="mood" name="mood" data-name="mood" required="" class="select2 w-select" data-placeholder="Select a reason">
                                 @foreach ($moods as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                 @endforeach
                            </select>                       
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
                            <label for="title" class="teksti">Name Reason</label>
                            <input type="text" class="text-field-3 w-input" maxlength="256" name="title"
                                data-name="title" placeholder="Reason name" id="title" required="">
                            <label for="img" class="teksti">Reason Image</label>
                            <input type="file" class="w-input" name="img" data-name="img" placeholder="Example Text" id="img">
                    </div>    
                    <input type="submit" id="savedata" value="Create Reason" class="button-3 w-button" />    
                </div>
                    
            </form> 
            </div>
           
        </div>
        <div class="reason-list">
            <div class="titujt">Reason List</div>
            <div class="author-table">
              <table id="reason_table" class="table table-striped table-bordered ajaxTable" style="width:100%">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Mood</th>
                          <th>Title</th>
                          <th>Image</th>
                          <th>Created At</th>
                          <th>Actions</th>                    
                      </tr>
                  </thead>        
              </table>
            </div>
          </div>
        
        <div class="modal fade" id='editReasonModal' role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Reason</h4>
                    </div>
                    <div class="modal-body">
                        <form id="update_reason_form" method="POST" data-parsley-validate
                            enctype="multipart/form-data" class="form-horizontal form-label-left">

                            <input type="hidden" name="id" id="reason_id" value=''>
                            <input type="hidden" name="action" data-action="action_update" value='edit'>
                            <div class="form-group">
                                <label for="mood" class="control-label col-md-3 col-sm-3 col-xs-12">Select Mood</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="select2-update-mood" name="mood" data-name="mood"
                                        class="select2 w-select">
                                         @foreach ($moods as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>
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
            $('#mood').select2({               
                placeholder: "Select Mood",               
                tags:true,
                createTag: function (params) {
                    // console.log('mydata:'+JSON.stringify(params));
                    var term = $.trim(params.term);

                    if ((term === ''&& term.length > 3)) {
                      return null;
                    }
                    
                    var lastMoodId = {{App\Models\Mood::max('id')}};
                    return {
                      id: lastMoodId+1,
                      text: term,
                      newTag: true // add additional parameters
                    }
                },
                insertTag: function (data, tag) {                     
                    data.push(tag);
                },
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
            
            $('#mood').on('select2:select', function (e) {
              let tag = e.params.data;
              if (tag.newTag === true)
              {  //save newmood into table                
                  axios.post("{{ route('mood.store') }}",{
                      id:tag.id,
                      title:tag.text
                  });
                  
              }
            });
            
            $('#select2-update-mood').select2({
            dropdownParent: $("#editReasonModal"),
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
            
            var table = $('#reason_table').DataTable({
                dom: 'Bfrtip', 
                pageLength:25,
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('reason.table') }}",
                columnDefs:[{
                        targets:[0,3,5],
                        className:'dt-body-center'
                }],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'mood', name: 'mood' },
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
        
       
        $('body').on('submit','#wf-form-reason-form,#update_reason_form',function(e) {        
            e.preventDefault();
            var formData = new FormData(this),
            dataAct = $(this).find('input:hidden[name=action]').val();
            
            if (dataAct == 'add'){
                $("#savedata").html('Sending..');
            }
            
            $.ajax({
                data: formData,
                url: "{{ route('reason.store')}}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {                    
                    if (dataAct == 'edit'){
                        $("#update_reason_form").trigger("reset");
                        $('#editReasonModal').modal('hide');
                    }else{
                        $('#wf-form-reason-form').trigger("reset");
                        $('.w-form-done').show().delay(5000).fadeOut();
                    }   
                    
                    setTimeout(function() {
                        $('#reason_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000); 
                },
                error: function(data) {
                    console.log('Error:', data);                    
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
            
        });
     
        
        
        $('body').on('click', 'a.delete-reason',function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            var id = $(this).data("id");
            $.ajax({
                data: {"id":id},
                url: "{{ route('reason.destroy', csrf_token()) }}",
                type: "DELETE",
                dataType: 'json',
                success: function(data) {                                       
                    $('.w-form-done').html(data['success']);
                    $('.w-form-done').show().delay(5000).fadeOut();
                    setTimeout(function() {
                        $('#reason_table').DataTable().ajax.reload(null, false);
                        $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });            
        });
        
         $('body').on('click', 'a.edit-reason', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                data: {"id":id},
                url: "{{ route('reason.edit', csrf_token()) }}",
                type: "GET",
                dataType: 'json',
                success: function(data) {                     
                    $('#reason_id').val(data.id);
                    $('#update_title').val(data.title); 
                    $('#select2-update-mood').select2().val(data.mood_id).trigger('change');
                    $('#hidden_image').val(data.image);
                    $('#my_image').attr('src', data.image);
                }
            });
        });   
        
    $(document).ready(function() {
       // $("#mood").select2();
    });
</script>   
@endsection
