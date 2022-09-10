@extends('layouts.admin')
@section('title')
    Quotes
@endsection
@section('content')
    <div class="quote-content">
        <div class="input-mobile">
            <div class="input-wraper-quote">
                <div class="quote-input">
                    <div class="quote">
                        <div class="w-form">
                            <form id="wf-form-quote-form" name="wf-form-quote-form" data-name="quote form" method="post">
                                <input type="hidden" name="action" id="action_add" value='add'>
                                <label for="quote" class="titujt">Quote</label>
                                <textarea id="quote" name="quote" maxlength="5000" data-name="quote" placeholder="Quote here" required=""
                                    class="textarea w-input"></textarea>
                                <label for="author" class="teksti">Author</label>
                                <select id="author" name="author" data-name="author" class="select2 w-select" data-placeholder="Select a author"></select>
                                
                                <label for="authorbook" class="teksti">From the Book</label>
                                <select id="authorbook" name="authorbook" data-name="authorbook" class="select2 w-select" data-placeholder="Select a book"></select>
                                <label for="categories" class="teksti">Categories</label>
                                <select id="categories" name="categories[]" data-name="categories" required="" multiple="multiple" class="select2 w-select" data-placeholder="Select some categories"></select>                                                         
                        </div>
                    </div>
                    <div class="mood">
                        <div class="w-form">                            
                            <label for="mood" class="titujt">Mood</label>
                            <select id="mood" name="mood" data-name="mood" class="select2 w-select" data-placeholder="Select a mood"></select>
                            <label for="reason" class="teksti">Reason</label>
                            <select id="reason"quote name="reason" data-name="reason" class="select2 w-select" data-placeholder="Select a reason"></select>
                            <label for="feeling" class="teksti">Feeling</label>
                            <select id="feeling" name="feeling" data-name="feeling" class="select2 w-select" data-placeholder="Select a feeling"></select>
                            <label id="reminder" class="w-checkbox reminder-checkbox">
                                <input type="checkbox" name="reminder" id="reminder" data-name="reminder" class="w-checkbox-input checkbox">
                                <span class="checkbox-text w-form-label" for="reminder"><i class="fas fa-bell blue"></i> Reminder?</span>
                            </label>
                                
                            <div class="w-form-done">
                                <div>Thank you! Your submission has been received!</div>
                            </div>
                            <div class="w-form-fail">
                                <div>Oops! Something went wrong while submitting the form.</div>
                            </div>
                        </div>
                         <input type="submit" id="savedata" value="Add Quote" class="button-3 w-button"/>        
                        </form> 
                    </div>
                </div>                
            </div>
            <div class="mobile-preview">
                <div class="iphone"><img src="images/splashLogo.png" loading="lazy" width="84"
                        sizes="(max-width: 991px) 100vw, 84px"
                        srcset="images/splashLogo-p-500.png 500w, images/splashLogo-p-800.png 800w, images/splashLogo-p-1080.png 1080w, images/splashLogo.png 1280w"
                        alt="" class="mobile-logo">
                    <div class="quote-preview">
                        <div id="quote-text" class="quote-text">Quote previews here</div>
                    </div>
                    <div class="mobile-bar"></div>
                </div>
            </div>
        </div>
        
        <div class="quote-list">
            <div class="titujt">Quote List</div>
            <div class="quote-table">              
                <table class='table-striped' id='quote_list'
                    data-toggle="table"
                    data-url="{{route('fetchquotes')}}"
                    data-click-to-select="true"
                    data-side-pagination="server"
                    data-locale="en-US"
                    data-pagination="true"
                    data-page-size="20"
                    data-page-list="[5, 10, 20, 50, 100, 200]"                                                                                
                    data-search="true"
                    data-advanced-search="true"                                        
                    data-id-table="advancedTable"                                       
                    data-show-columns="true"
                    data-show-refresh="true" data-trim-on-search="false"
                    data-sort-name="id" data-sort-order="desc"
                    data-mobile-responsive="true"
                    data-toolbar="#toolbar"
                    data-show-export="true"
                    data-export-data-type ="all"
                    data-maintain-selected="true"                    
                    data-export-types='["csv","json","txt","excel"]'
                    data-export-options='{
                            "fileName": "quotes-list-<?=date('d-m-y')?>",
                            "ignoreColumn": ["state"]	
                    }'                    
                    data-query-params="queryParams_1">
                    <thead>
                        <tr>
                            <th data-field="state" data-checkbox="true" data-visible="false"></th>
                            <th data-field="id" data-sortable="false">ID</th>
                            <th data-field="categories" data-sortable="false">Categories</th>
                            <th data-field="author_id" data-sortable="false" data-visible="false">Author ID</th>
                            <th data-field="author" data-sortable="false">Author</th>
                            <th data-field="quote" data-sortable="false">Quote</th>
                            <th data-field="authorbook_id" data-sortable="false" data-visible="false">Book ID</th>
                            <th data-field="authorbook">Book Ref</th>
                            <th data-field="reminder" data-sortable="false"><i class="fas fa-bell blue"></i></th>
                            <th data-field="translation" data-sortable="false">Translation</th> 
                            <th data-field="created_at" data-sortable="false">Created At</th>
                            <th data-field="action" data-sortable="false" data-events="">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        
        <div class="modal fade" id='editQuoteModal' role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Quote</h4>
                    </div>
                    <div class="modal-body">
                        <form id="update_quote_form" method="POST" data-parsley-validate
                            enctype="multipart/form-data" class="form-horizontal form-label-left">

                            <input type="hidden" name="id" id="quote_id" value=''>
                            <input type="hidden" name="action" data-action="action_update" value='edit'>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Quote</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <textarea id="quote-update" name="quote" maxlength="5000" data-name="quote" placeholder="Quote here" required=""
                                    class="textarea w-input"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="mood" class="control-label col-md-3 col-sm-3 col-xs-12">Author</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="author-update" name="author" data-name="author"
                                        class="select2 w-select" data-placeholder="Select a author">
                                        @foreach ($author as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="authorbook" class="control-label col-md-3 col-sm-3 col-xs-12">From the Book</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="authorbook-update" name="authorbook" data-name="authorbook" class="select2 w-select" data-placeholder="Select a book">
                                       @foreach ($authorbook as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="mood" class="control-label col-md-3 col-sm-3 col-xs-12">Categories</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="categories-update" name="categories[]" data-name="categories" required="" multiple="multiple" class="select2 w-select" data-placeholder="Select some categories">
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Mood</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="mood-update" name="mood" data-name="mood" class="select2 w-select" data-placeholder="Select a mood">
                                        @foreach ($moods as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Reason</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="reason-update" name="reason" data-name="reason" class="select2 w-select" data-placeholder="Select a reason">
                                        @foreach ($reasons as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Feeling</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="feeling-update" name="feeling" data-name="feeling" class="select2 w-select" data-placeholder="Select a feeling">
                                        @foreach ($feelings as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="reminder">Reminder <i
                                        class='fas fa-bell'></i></label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="checkbox" name="reminder" id="reminder-update" class="form-check-input">
                                </div>
                            </div>
                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" id="update_submit_btn" class="btn btn-danger">Update Now</button>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
                                </div>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
        </div> 
        
        <div class="modal fade" id='multiModal' role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Quote Translation</h4>
                    </div>                    
                    <div class="modal-body">
                        <form id="multi-quote-form" method="POST" data-parsley-validate
                            enctype="multipart/form-data" class="form-horizontal form-label-left">

                            <input type="hidden" name="id" id="multiquoteid" value=''>
                            <input type="hidden" name="action" data-action="action_update" value='edit'>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Quote</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <textarea id="defaultquote" name="defaultqupte" maxlength="5000" data-name="defaultqupte" class="textarea w-input" readonly></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Choose Country</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="country" name="country" data-name="country" class="select2 w-select" data-placeholder="Choose country" required="true"></select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Quote Translation</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <textarea id="newquote" name="newquote" maxlength="5000" data-name="newquote" class="textarea w-input" required="true"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="msgMultilang" class="w-form-done">
                                    <div>Adding new translation success!</div>
                                </div>
                            </div>    
                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" id="multiquote_submit_btn" class="btn btn-primary">Create Translation</button>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
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
    
    
    var num=1;
    $('#quote_list').bootstrapTable({
        onPageChange: function (number, size) {                       
            num= number;
            return false;
        }
    });
    
    function queryParams_1(p){                   
        var searchInput = $(".bootstrap-table .fixed-table-toolbar .search input").val();                                       
        var param = {
            limit:p.limit,
            sort:p.sort,
            order:p.order,
            offset:p.offset,
            search:searchInput,                       
            lang:"mimi",
            page:num
        }

        var advSearchFieldValue = $('#advancedSearch').serializeArray(),
                advCount = 0;
        $.each(advSearchFieldValue, function(index, fieldValuePair) {
            if (fieldValuePair.value != ""){
                param[fieldValuePair.name] = fieldValuePair.value;
                advCount++;
            }
        });

        if (advCount > 0){
            param['advs'] = 1;
        }

        return param;          
    }
        
    $(function(){        
        var $prevquote = $("#quote-text");
        $("#quote").keyup(function() {
            var tempContent = this.value;            
            tempContent = tempContent.replace(/\n/g, "<br>\n");
            $prevquote.html( tempContent );
        });
        
        $('#country').select2({ 
            dropdownParent: $("#multiModal"),
            allowClear:true,
            ajax:{
                url: "{{ route('fetchcountry') }}",
                type:'GET',
                datatype:'json',    
                delay:250,          
                processResults:function(data){
                    return {
                        results:  $.map(data, function (item) {
                                return {
                                  text: item.country_name + " (" +item.country_code+")",
                                  id: item.country_code
                              }
                          })
                        };   
                },
                cache:true
            }
        });
        
        $('#quote_list tbody').on('click','button.add-multi',function(){            
            var qtext = $(this).closest('tr').find('td:eq(3)').text();
            var tempContent = qtext.replace(/\n/g, "<br>\n");            
            $("#defaultquote").val(tempContent);
            $('#multiquoteid').val($(this).data("textid"));            
        });
        
        
        $('body').on('submit','#multi-quote-form',function(e) {        
            e.preventDefault();
            var formData = new FormData(this);
            
            $.ajax({
                data: formData,
                url: "{{ route('multilang.store')}}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    $('#msgMultilang.w-form-done').show().delay(2000).fadeOut();
                    $("#newquote").val("");
                    $('#country').val("").trigger('change');                    
                    $('#quote_list').bootstrapTable('refresh'); 
                },
                error: function(data) {
                    console.log('Error:', data);                    
                    
                }
            });            
            
        });
        
        
        $('#author-update').select2({ 
            dropdownParent: $("#editQuoteModal"),
            allowClear:true,
            ajax:{
                url: "{{ route('fetchauthor') }}",
                type:'GET',
                datatype:'json',    
                delay:250,          
                processResults:function(data){
                    return {
                        results:  $.map(data, function (item) {
                                return {
                                  text: item.name,
                                  id: item.id
                              }
                          })
                        };   
                },
                cache:true
            }
        });
        
        var idauthor_up="";
        $("#author-update").on("select2:select",function(e){           
            idauthor_up = e.params.data.id;             
            $('#authorbook-update').val("").trigger("change"); 
        });
        
        $("#authorbook-update").select2({  
            dropdownParent: $("#editQuoteModal"),
            allowClear:true,
            ajax:{
                url: "{{ route('fetchbook') }}",
                type:'GET',
                datatype:'json',    
                delay:250,  
                data: function (params) {
                    return {
                      search: params.term,
                      id: $("#author-update").val()
                    }                   
                  },
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
        
        $('#categories-update').select2({ 
            allowClear:true,
            tags:true,
            ajax:{
                url: "{{ route('fetchcategory') }}",
                type:'GET',
                datatype:'json',    
                delay:250,          
                processResults:function(data){
                    return {
                        results:  $.map(data, function (item) {
                                return {
                                  text: item.name,
                                  id: item.id
                              }
                          })
                        };   
                },
                cache:true
            }
        });
            
       $('#mood-update').select2({            
            allowClear:true,
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
        
        var idMood_up="";
        $("#mood-update").on("select2:select",function(e){
            idMood_up = e.params.data.id;            
            $('#reason-update').val("").trigger("change");
            $('#feeling-update').val("").trigger("change");
        });
        
        $('#reason-update').select2({  
            allowClear:true,
            ajax:{
                url: "{{ route('showreason') }}",
                type:'GET',
                datatype:'json',    
                delay:250,  
                data: function (params) {
                    return {
                      search: params.term,
                      id: idMood_up
                    }                   
                  },
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
        
        var idReason_up="";
        $("#reason-update").on("select2:select",function(e){
            idReason_up = e.params.data.id;           
            $('#feeling-update').val("").trigger("change");
        });
        
        $('#feeling-update').select2({ 
            allowClear:true,
            ajax:{
                url: "{{ route('showfeeling') }}",
                type:'GET',
                datatype:'json',    
                delay:250,  
                data: function (params) {
                   return {
                      search: params.term,
                      id: idReason_up
                    }                    
                  },
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
               
        $('#author').select2({ 
            allowClear:true,
            ajax:{
                url: "{{ route('fetchauthor') }}",
                type:'GET',
                datatype:'json',    
                delay:250,          
                processResults:function(data){
                    return {
                        results:  $.map(data, function (item) {
                                return {
                                  text: item.name,
                                  id: item.id
                              }
                          })
                        };   
                },
                cache:true
            }
        });
        
        
       var idauthor="";
        $("#author").on("select2:select",function(e){            
            idauthor = e.params.data.id;
            $('#authorbook').val("").trigger("change");
        });
        
        $("#authorbook").select2({  
            allowClear:true,
            ajax:{
                url: "{{ route('fetchbook') }}",
                type:'GET',
                datatype:'json',    
                delay:250,  
                data: function (params) {
                    return {
                      search: params.term,
                      id: idauthor
                    }                   
                  },
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
        
        
        $('#categories').select2({ 
            allowClear:true,
            tags:true,
            ajax:{
                url: "{{ route('fetchcategory') }}",
                type:'GET',
                datatype:'json',    
                delay:250,          
                processResults:function(data){
                    return {
                        results:  $.map(data, function (item) {
                                return {
                                  text: item.name,
                                  id: item.id
                              }
                          })
                        };   
                },
                cache:true
            }
        });
            
       $('#mood').select2({            
            allowClear:true,
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
        
        var idMood="";
        $("#mood").on("select2:select",function(e){
            idMood = e.params.data.id;
            $('#reason').val("").trigger("change");
            $('#feeling').val("").trigger("change");           
        });
        
        $('#reason').select2({  
            allowClear:true,
            ajax:{
                url: "{{ route('showreason') }}",
                type:'GET',
                datatype:'json',    
                delay:250,  
                data: function (params) {
                    return {
                      search: params.term,
                      id: idMood
                    }                   
                  },
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
        
        var idReason="";
        $("#reason").on("select2:select",function(e){
            idReason = e.params.data.id;
            $('#feeling').val("").trigger("change");           
        });
        
        $('#feeling').select2({ 
            allowClear:true,
            ajax:{
                url: "{{ route('showfeeling') }}",
                type:'GET',
                datatype:'json',    
                delay:250,  
                data: function (params) {
                   return {
                      search: params.term,
                      id: idReason
                    }                    
                  },
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
        
        
        $('body').on('submit','#wf-form-quote-form,#update_quote_form',function(e) {        
            e.preventDefault();
            var formData = new FormData(this),
            dataAct = $(this).find('input:hidden[name=action]').val();
            
            if (dataAct == 'add'){
                $("#savedata").html('Sending..');
            }
            
            $.ajax({
                data: formData,
                url: "{{ route('quotes.store')}}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {                    
                    if (dataAct == 'edit'){
                        $("#update_quote_form").trigger("reset");
                        $('#author-update').val("").trigger('change'); 
                        $('#authorbook-update').val("").trigger('change');
                        $('#categories-update').val("").trigger('change');
                        $('#mood-update').val("").trigger('change');
                        $('#reason-update').val("").trigger('change');
                        $('#feeling-update').val("").trigger('change');
                        $('#editQuoteModal').modal('hide');                       
                    }else{
                        $('#wf-form-quote-form').trigger("reset");
                        $('#mood').val("").trigger("change");
                        $('#reason').val("").trigger("change");
                        $('#feeling').val("").trigger("change");
                        $('#author').val("").trigger("change");
                        $('#authorbook').val("").trigger("change");
                        $('#categories').val("").trigger("change");
                        $('#quote-text').val("Quote previews here");                       
                        $('.w-form-done').show().delay(5000).fadeOut();
                    }                       
                    
                    $('#quote_list').bootstrapTable('refresh');
                },
                error: function(data) {
                    console.log('Error:', data);                    
                    $('.w-form-fail').show().delay(5000).fadeOut();
                }
            });
            
        }); 
    });
    
    $('body').on('click', 'a.edit-quote', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            data: {"id":id},
            url: "{{ route('quotes.edit', csrf_token()) }}",
            type: "GET",
            dataType: 'json',
            success: function(data) { 
                $('#quote_id').val(data.id);
                $('#quote-update').val(data.quote);                   
                $('#author-update').val(data.author_id).trigger('change'); 
                $('#authorbook-update').val(data.authorbook_id).trigger('change');
                $('#categories-update').val(data.categories).trigger('change');
                $('#mood-update').val(data.mood_id).trigger('change');
                $('#reason-update').val(data.reason_id).trigger('change');
                $('#feeling-update').val(data.feeling_id).trigger('change');
                if (data.reminder == 1){
                    $('#reminder-update').prop('checked', true);
                }else{
                     $('#reminder-update').prop('checked', false);
                }

            }
        });
    });
        
    $("#editQuoteModal").on("hidden.bs.modal", function () {            
        $("#update_quote_form").trigger('reset');
        $('#author-update').val("").trigger('change'); 
        $('#authorbook-update').val("").trigger('change');
        $('#categories-update').val("").trigger('change');
        $('#mood-update').val("").trigger('change');
        $('#reason-update').val("").trigger('change');
        $('#feeling-update').val("").trigger('change');
    });
    
    $("#multiModal").on("hidden.bs.modal", function () {
        $("#multi-quote-form").trigger("reset");
        $('#country').val("").trigger('change');
    }); 
        
    $('body').on('click', 'a.delete-quote',function(e) {
        e.preventDefault();
        $(this).html('Sending..');
        var id = $(this).data("id");
        
        $.ajax({
            data: {"id":id},
            url: "{{ route('quotes.destroy', csrf_token()) }}",
            type: "DELETE",
            dataType: 'json',
            success: function(data) {                                       
                $('.w-form-done').html(data['success']);
                $('.w-form-done').show().delay(5000).fadeOut();
                $('#quote_list').bootstrapTable('refresh');                
            },
            error: function(data) {
                console.log('Error:', data);
                $('.w-form-fail').show().delay(5000).fadeOut();
            }
        });     
       
    });
        
</script>
@endsection
