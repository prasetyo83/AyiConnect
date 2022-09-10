@extends('layouts.admin')
@section('title')
    Authors Details
@endsection
@section('content')
    <div class="autor-container">
        <div class="author-wrapper">
            <div class="authors-content">
                <div class="search-add-author">
                    <div class="titujt">Author</div>
                    <div class="search_author"></div>
                </div>
                <div class="author-data">
                    <div class="profile"><img src="/storage/author/{{ $authors['image'] }}" loading="lazy" width="75"
                            alt="">
                        <div class="html-embed w-embed">
                            <style>
                                table {
                                    font-family: poppins;
                                    border-collapse: collapse;
                                    width: 100%;
                                }

                                td,
                                th {
                                    border: 0px solid #dddddd;
                                    text-align: left;
                                    padding: 8px;
                                }

                                td {
                                    font-size: 12px
                                }
                            </style>
                            <table>
                                <tr>
                                    <td>Author Name</td>
                                    <td>Quote Count</td>
                                    <td>ID</td>
                                </tr>
                                {{-- @foreach ($authors as $author) --}}
                                <tr>
                                    <th>{{ $authors['name'] }}</th>
                                    <th>{{ $counts }}</th>
                                    <th>{{ $authors['id'] }}</th>
                                    <?php $authorid = $authors['id']; ?>
                                </tr>
                                {{-- @endforeach --}}
                            </table>
                        </div>
                        <a href="#" class="edit-author w-button"></a>
                    </div>
                    <div class="tags">

                        @foreach ($authors['authorhastag'] as $p)
                            <div class="tags-text">{{ $p->hastag->hastag }}</div>
                        @endforeach
                    </div>
                    <div></div>
                </div>
                <div class="nentitujt">Analytics</div>
                <div class="w-embed w-script">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                    <script></script>
                </div>

                <div class="modal fade" id='addQuoteModal' tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Add Quote</h4>
                            </div>
                            <div class="modal-body">
                                <div class="quote-input">
                                    <div class="quote">
                                        <div class="w-form">
                                            <form id="wf-form-quote-form" name="wf-form-quote-form" data-name="quote form"
                                                method="post">
                                                <input type="hidden" name="action" id="action_add" value='add'>
                                                <label for="quote" class="titujt">Quote</label>
                                                <textarea id="quote" name="quote" maxlength="5000" data-name="quote" placeholder="Quote here" required=""
                                                    class="textarea w-input"></textarea>
                                                <input type="hidden" name="author" id="idauthor"
                                                    value="{{ $authorid }}" <label for="authorbook" class="teksti">From
                                                the Book</label>
                                                <select id="authorbook" name="authorbook" data-name="authorbook"
                                                    class="select2 w-select" data-placeholder="Select a book"></select>
                                                <label for="categories" class="teksti">Categories</label>
                                                <select id="categories" name="categories[]" data-name="categories"
                                                    required="" multiple="multiple" class="select2 w-select"
                                                    data-placeholder="Select some categories"></select>
                                        </div>
                                    </div>
                                    <div class="mood">
                                        <div class="w-form">
                                            <label for="mood" class="titujt">Mood</label>
                                            <select id="mood" name="mood" data-name="mood" class="select2 w-select"
                                                data-placeholder="Select a mood"></select>
                                            <label for="reason" class="teksti">Reason</label>
                                            <select id="reason"quote name="reason" data-name="reason"
                                                class="select2 w-select" data-placeholder="Select a reason"></select>
                                            <label for="feeling" class="teksti">Feeling</label>
                                            <select id="feeling" name="feeling" data-name="feeling"
                                                class="select2 w-select" data-placeholder="Select a feeling"></select>
                                            <label id="reminder" class="w-checkbox reminder-checkbox">
                                                <input type="checkbox" name="reminder" id="reminder"
                                                    data-name="reminder" class="w-checkbox-input checkbox">
                                                <span class="checkbox-text w-form-label" for="reminder">Reminder?</span>
                                            </label>

                                            <div class="w-form-done" id="done-quote">
                                                <div>Thank you! Your submission has been received!</div>
                                            </div>
                                            <div class="w-form-fail" id="fail-quote">
                                                <div>Oops! Something went wrong while submitting the form.</div>
                                            </div>
                                        </div>
                                        <input type="submit" id="savedata" value="Add Quote"
                                            class="button-3 w-button" />
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="update_section_result"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container tombol" style="margin-top:12px">

                    <div class="row">
                        <div class="col-md-12 text-center">

                            <a href="#" class="button-3 w-button addQuote" data-toggle='modal'
                                data-target='#addQuoteModal' title='
                            add Quote'
                                data-id={{ $authorid }}>Add Quote</a>
                        </div>

                    </div>
                </div>

            </div>
            <div class="links">
                <div class="author-links socials">
                    <div class="w-form">
                        <form id="Social-links-form" name="wf-form-Social-links" data-name="Social links"
                            method="post">
                            <input type="hidden" name="author_id" id="author_id" value="{{ $authorid }}">
                            <label for="link-social" class="nentitujt">Social Link</label><input type="text"
                                class="w-input" maxlength="256" name="link" data-name="link" placeholder=""
                                id="link" required=""><label for="image-social" class="teksti">Media Social</label>
                            <select id="social" name="network" data-name="network" class="select2 w-select" data-placeholder="Select a social media"></select>
                            <input type="submit" style="margin-top:10px;" value="Create Link" data-wait="Please wait..." id="social-button"
                                class="button-3 w-button">

                            <div class="w-form-done link">
                                <div>Thank you! Your submission has been received!</div>
                            </div>
                            <div class="w-form-fail link">
                                <div>Oops! Something went wrong while submitting the form.</div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="author-links books">
                    <div class="w-form">
                        <form id="Book-links-form" name="wf-form-Book-links" data-name="Book links" method="post"
                            enctype="multipart/form-data">
                            <input type="hidden" name="author_id" id="author_id" value="{{ $authorid }}">
                            <label for="link-book" class="nentitujt">Book Title</label><input type="text"
                                class="w-input" maxlength="256" name="title" data-name="title" placeholder=""
                                id="title" required="">
                            <label for="link-book" class="nentitujt">Book Link</label><input type="text"
                                class="w-input" maxlength="256" name="link" data-name="link" placeholder=""
                                id="link" required=""><label for="image-book" class="teksti">Choose Image</label>
                            <input type="file" class="w-input" maxlength="256" name="image" data-name="image"
                                placeholder="" id="image">
                            <label for="country" class="teksti">Choose Country</label>
                            <select id="country" name="country_code[]" multiple="multiple" data-name="contry_code" class="select2 w-select">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country_code }}">{{ $country->country_name }}</option>
                                @endforeach
                            </select>
                            <input type="submit" style="margin-top:10px;" value="Create Book" data-wait="Please wait..." id="book-button"
                                class="button-3 w-button">
                            <div class="w-form-done books">
                                <div>Thank you! Your submission has been received!</div>
                            </div>
                            <div class="w-form-fail books">
                                <div>Oops! Something went wrong while submitting the form.</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="list-container">
            <div data-current="author-quotes" data-easing="ease" data-duration-in="300" data-duration-out="100"
                class="w-tabs">
                <div class="tabs-menu w-tab-menu">
                    <a data-w-tab="author-quotes" id="home-tab" class="tab-link-tab-1 w-inline-block w-tab-link "
                        data-toggle="tab" role="tab" data-target="#author-links">
                        <div>Author Quotes</div>
                    </a>
                    <a data-w-tab="social-links" id="home-atab"
                        class="tab-link-tab-2 w-inline-block w-tab-link w--current" data-toggle="tab" role="tab"
                        data-target="#social-links">
                        <div>Social Links</div>
                    </a>
                    <a data-w-tab="book-links" id="homde-tab" class="tab-link-tab-3 w-inline-block w-tab-link"
                        data-toggle="tab" role="tab" data-target="#book-links">
                        <div>Book Links</div>
                    </a>
                </div>
                <div class="w-tab-content">
                    <div data-w-tab="author-quotes" class="tab-pane-tab-1 w-tab-pane w--tab-active" id="author-links">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="table-responsive">
                                    <table id="quotes_table" class="table table-striped table-bordered ajaxTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Categories</th>
                                                <th>Quote</th>
                                                <th>Book Ref</th>
                                                <th>Reminder</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div data-w-tab="social-links" class="tab-pane-tab-2 w-tab-pane" id="social-links">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">

                                <div class="table-responsive">
                                    <table id="social_table" class="table table-striped table-bordered ajaxTable">
                                        <thead>
                                            <tr>
                                                <th>
                                                    id
                                                </th>
                                                <th>
                                                    Link
                                                </th>
                                                <th>
                                                    Network
                                                </th>
                                                <th>
                                                    Date Created
                                                </th>
                                                <th>
                                                    Operate
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-w-tab="book-links" class="tab-pane-tab-3 w-tab-pane" id="book-links">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="table-responsive">
                                    <table id="book_table" class="table table-striped table-bordered ajaxTable">
                                        <thead>
                                            <tr>
                                                <th>
                                                    id
                                                </th>
                                                <th>
                                                    Tittle
                                                </th>
                                                <th>
                                                    Link
                                                </th>
                                                <th>
                                                    image
                                                </th>
                                                <th>
                                                    Country Code
                                                </th>
                                                <th>
                                                    Date Created
                                                </th>
                                                <th>
                                                    Operate
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id='editlinkModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit links</h4>
                    </div>
                    <div class="modal-body">
                        <form id="update_link_form" method="POST" data-parsley-validate
                            class="form-horizontal form-label-left">

                            <input type="hidden" name="id" id="link_id" value=''>
                            <input type="hidden" name="author_id" id="author_id" value="{{ $authorid }}">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">link : </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="text" name="link" id="link_update" class="form-control"
                                        placeholder="Enter link Name..." required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="premium">Social Media
                                    :</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="social-update" name="network" data-name="network" class="select2 w-select" data-placeholder="Select a social media">
                                        @foreach ($social as $item)
                                        <option value="{{ $item->id }}" data-icon="{{$item->icon}}">{{ $item->name }}</option>    
                                        @endforeach    
                                    </select>
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
                            <div id="update_link_result"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id='editBookModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Book Link</h4>
                    </div>
                    <div class="modal-body">
                        <form id="update_book_form" method="POST" data-parsley-validate enctype="multipart/form-data"
                            class="form-horizontal form-label-left">

                            {{-- <input type="hidden" name="id" id="categories_id" value=''> --}}
                            <input type="hidden" name="id" id="book_id" value=''>
                            <input type="hidden" name="author_id" id="author_id" value="{{ $authorid }}">
                            <input type="hidden" id="deltag" name="deltag" />
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Title : </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="text" name="title" id="title_update" class="form-control"
                                        placeholder="Enter link Name..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Book Link: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="text" name="link" id="update_booklink" class="form-control"
                                        placeholder="Enter Categories Name..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Country Name: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select id="country1" name="country_code[]" data-name="country_code"
                                        class="select2 w-select form-control" multiple="multiple">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->country_code }}">{{ $country->country_name }}
                                            </option>
                                        @endforeach



                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Book Image: </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                    <div class="image"><img id="my_image" src="" height="50"
                                            width="50"></div>
                                    <p><b>Note: Leave it blank for no change.</b></p>
                                    <input type="hidden" name="hidden_image" id="hidden_image" value=''>
                                    <input type="file" name="image" id="update_image" class="form-control"
                                        placeholder="Enter Section Name...">
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
    </div>
@endsection
@section('script')
    <script>
        var xVal = [];
        var yVal = [];
        @parent
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(function(){ 
            function formatData (item) {
              if (!item.id) return $("<span><i class='fas fa-retweet'></i> "+item.text+"</span>");
            
              var $span = $("<span><i class='"+item.icon+"'></i> "+item.text+"</span>");              
              return $span;
            }
            
            function formatSelection (item) {
              if (!item.id) return $("<span><i class='fas fa-retweet'></i> "+item.text+"</span>");
            
              var $span = $("<span><i class='"+item.icon+"'></i> <b>"+item.text+"</b></span>");              
              return $span;
            }
            
            function formatSocialUpdate(state){
                if (!state.id) {
                    return state.text;
                }                
                
                var icon = $(state.element).attr('data-icon');                
                var $state = $("<span><i class='"+icon+"'></i> <b>"+state.text+"</b></span>");  
                return $state;
            }
            
             $('#social-update').select2({              
                templateSelection: formatSocialUpdate,
                templateResult: formatSocialUpdate
             });
        
            $('#social').select2({            
                allowClear:true,
                ajax:{
                    url: "{{ route('fetchsocial') }}",
                    type:'GET',
                    datatype:'json',    
                    delay:250,                    
                    processResults:function(data){                        
                        return {
                            results:  $.map(data, function (item) {
                                    return {
                                      text: item.name,                                     
                                      id: item.id,
                                      icon:item.icon
                                  }
                              })
                            };   
                    },
                    cache:true
                },
                escapeMarkup: function(m) { return m; },
                templateSelection: formatSelection,
                templateResult: formatData,
            });
        });
        
        
        var dtag = "";
        function setChart(chart, stat) {
            if (stat == "awal") {
                $.ajax({
                    url: "/authorsdetail/" + "{{ $authorid }}" + "/chart",
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        // alert(JSON.stringify(data));
                        // alert(data.name);
                        // xVal=[];
                        // yVal=[];
                        $.each(data, function(key, value) {
                            // const obj = JSON.parse(value);
                            // if (! value.name in xVal ){
                            // xVal.push(value.name);
                            // yVal.push(value.jumlah);
                            chart.data.labels.push(value.name);
                            chart.data.datasets[0].data.push(value.jumlah);


                        });
                        // alert(xVal);

                        chart.update();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.responseText);
                    },
                });
            } else

            {
                chart.data.labels = [];
                chart.data.datasets[0].data = [];
                $.ajax({
                    url: "/authorsdetail/" + "{{ $authorid }}" + "/chart",
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        // alert(JSON.stringify(data));
                        // alert(data.name);
                        // xVal=[];
                        // yVal=[];
                        $.each(data, function(key, value) {
                            // const obj = JSON.parse(value);
                            // if (! value.name in xVal ){
                            chart.data.labels.push(value.name);
                            chart.data.datasets[0].data.push(value.jumlah);

                            chart.update();

                        });
                        // alert(xVal);
                        // alert(yVal);
                        // chart.labels = xVal;
                        // chart.datasets[0].data = yVal;
                        
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.responseText);
                    },
                });
            }

        }
        var barColors = [
            "#b91d47",
            "#00aba9",
            "#2b5797",
        ];
        var myChart = new Chart("myChart", {
            type: "doughnut",
            data: {
                labels: [],
                datasets: [{
                    backgroundColor: barColors,
                    data: []
                }]
            },
        });

        // 

        // var xValues = xVal;
        // var yValues = yVal;

        $('#country').select2()
        {

        }
        $('#country1').select2()
        $(document).ready(function() {            
            $("#social1").select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        });
        
        

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span ><i class="fab fa-' + state.id + '"> ' + state.text + '</span>'
            );
            return $state;
        }



        $(function() {
            
            window.onresize = function() {
                quote_table.columns.adjust().responsive.recalc();
                book_table.columns.adjust().responsive.recalc();
                socio_table.columns.adjust().responsive.recalc();
            }
            setChart(myChart, "awal");
            var socio_table= $('#social_table').DataTable({
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
                // responsive: true,
                autoWidth: false, //<---
                responsive: true,

                ajax: {
                    url: "/authorsdetail/" + "{{ $authorid }}" + "/social",
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'link',
                        name: 'link',

                    },
                    {
                        data: 'network',
                        name: 'network'
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

            var book_table =$('#book_table').DataTable({
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
                // responsive: true,
                autoWidth: false, //<---
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/authorsdetail/" + "{{ $authorid }}" + "/book",

                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title',

                    },
                    {
                        data: 'link',
                        name: 'link',

                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'country_code',
                        name: 'country_code'
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
            var quote_table = $('#quotes_table').DataTable({
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
                responsive: true,
                autoWidth: false, //<---
                ajax: {
                    url: "/authorsdetail/" + "{{ $authorid }}" + "/quote",
                },
                columnDefs: [{
                    targets: [0, 4],
                    className: 'dt-body-center'
                }],

                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'categories',
                        name: 'categories',
                        render: function(id, type, full) {

                            return id;
                        }
                    },
                    {
                        data: 'quote',
                        name: 'quote'
                    },
                    {
                        data: 'book',
                        name: 'book'
                    },
                    {
                        data: 'reminder',
                        name: 'reminder',
                        render: function(id, type, full) {
                            var rem = (id == 1) ? "<i class='fas fa-bell blue'></i>" :
                                "<i class='fas fa-bell-slash'></i>";
                            return rem;
                        }
                    },

                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ],
                order: [
                    [0, 'asc']
                ],

            });


        });

        $('body').on('submit', '#Social-links-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var actionType = $('#btn-save').val();
            $('#savedata').html('Sending..');

            $.ajax({
                data: formData,
                url: "{{ route('authorsocial.store') }}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    $('#Social-links-form').trigger("reset");
                    $('#social').val("").trigger('change');
                    $('.w-form-done.link').show().delay(5000).fadeOut();
                    setTimeout(function() {
                        $('#social_table').DataTable().ajax.reload(null, false);
                        // $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    // alert("error e "+data);
                    $('.sw-form-fail.link').show().delay(5000).fadeOut();
                }
            });
        });

        $('body').on('submit', '#update_link_form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var actionType = $('#btn-save').val();
            $('#savedata').html('Sending..');

            $.ajax({
                data: formData,
                url: "{{ route('authorsocial.store') }}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    $('#update_link_form').trigger("reset");
                    $('.w-form-done.link').show().delay(5000).fadeOut();
                    $('#editlinkModal').modal('hide');
                    $(this).html('Update Now');
                    // $('#section_table').bootstrapTable('refresh');
                    setTimeout(function() {
                        $('#social_table').DataTable().ajax.reload(null, false);
                        // $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log(data);
                    // alert(data->error());
                    $('.w-form-fail.link').show().delay(5000).fadeOut();
                }
            });
        });
        $('body').on('click', '.delete-social', function() {
            // alert('coba');
            var id = $(this).data("id");
            confirm("Are You sure want to delete this Post!");
            $.ajax({
                type: "DELETE",
                url: "{{ route('authorsocial.store') }}" + '/' + id,
                success: function(data) {
                    setTimeout(function() {
                        $('#social_table').DataTable().ajax.reload(null, false);
                        // $('#section_table').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        $('body').on('click', '.edit-social', function() {
            var id = $(this).data('id');
            
            $.get("{{ route('authorsocial.index') }}" + '/' + id + '/edit', function(data) {               
                $('#link_id').val(data.id);
                $('#link_update').val(data.link);  
                
                socialId = "";
                if ((data.social_id == null)|| (data.social_id != "")){
                    socialId = data.social_id;
                }                
                $('#social-update').val(socialId).trigger('change');                
            });


        });
        // book
        $('body').on('submit', '#Book-links-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var actionType = $('#btn-save').val();
            $('#savedata').html('Sending..');

            $.ajax({
                data: formData,
                url: "{{ route('authorbook.store') }}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    $('#Book-links-form').trigger("reset");
                    $('#country').val("").trigger('change');
                    $('.w-form-done.book').show().delay(5000).fadeOut();
                    setTimeout(function() {
                        $('#book_table').DataTable().ajax.reload(null, false);
                        // $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    // alert("error e "+data);
                    $('.sw-form-fail.book').show().delay(5000).fadeOut();
                }
            });
        });

        $('body').on('submit', '#update_book_form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var actionType = $('#btn-save').val();
            $('#savedata').html('Sending..');



            $.ajax({
                data: formData,
                url: "{{ route('authorbook.store') }}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    $('#update_book_form').trigger("reset");
                    $('.w-form-done.book').show().delay(5000).fadeOut();
                    $('#editBookModal').modal('hide');
                    $(this).html('Update Now');
                    // $('#section_table').bootstrapTable('refresh');
                    setTimeout(function() {
                        $('#book_table').DataTable().ajax.reload(null, false);
                        // $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log(data);
                    // alert(data->error());
                    $('.w-form-fail.book').show().delay(5000).fadeOut();
                }
            });
        });
        $('body').on('click', '.delete-book', function() {
            // alert('coba');
            var id = $(this).data("id");
            confirm("Are You sure want to delete this Book link!");
            $.ajax({
                type: "DELETE",
                url: "{{ route('authorbook.store') }}" + '/' + id,
                success: function(data) {
                    setTimeout(function() {
                        $('#book_table').DataTable().ajax.reload(null, false);
                        // $('#section_table').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });
        $('body').on('click', '.edit-book', function() {
            var id = $(this).data('id');
            // alert(id);
            $.get("{{ route('authorbook.index') }}" + '/' + id + '/edit', function(data) {
                // alert(data.authorbookcountries);
                $('#book_id').val(data.id);
                $('#title_update').val(data.title);
                $('#update_booklink').val(data.link);
                $('#country1').val(data.country_code);
                // // $("#update_section_id").select2("val", data.section_id);
                $('#country1').select2().trigger('change');
                $('#hidden_image').val(data.image);
                $('#my_image').attr('src', '/storage/book/' + data.image);

            });


        });


        ///=====quote

        var idauthor = "";

        // idauthor = $("#quote").val();
        // alert(idauthor);

        $('body').on('click', 'a.addQuote', function(e) {
            e.preventDefault();
            idauthor = $(this).data('id');
            // alert(idauthor);
            $("#idauthor").val(idauthor);

        });

        var $prevquote = $("#quote-text");
        $("#quote").keyup(function() {
            $prevquote.html(this.value);
        });


        $("#authorbook").select2({
            allowClear: true,
            ajax: {
                url: "{{ route('fetchbook') }}",
                type: 'GET',
                datatype: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        id: idauthor
                    }
                },
                processResults: function(data) {
                    // alert( JSON.stringify(data));
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


        $('#categories').select2({
            allowClear: true,
            // tags: true,
            ajax: {
                url: "{{ route('fetchcategory') }}",
                type: 'GET',
                datatype: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#mood').select2({
            allowClear: true,
            ajax: {
                url: "{{ route('showmood') }}",
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

        var idMood = "";
        $("#mood").on("select2:select", function(e) {
            idMood = e.params.data.id;
            $('#reason').val("").trigger("change");
            $('#feeling').val("").trigger("change");
        });

        $('#reason').select2({
            allowClear: true,
            ajax: {
                url: "{{ route('showreason') }}",
                type: 'GET',
                datatype: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        id: idMood
                    }
                },
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

        var idReason = "";
        $("#reason").on("select2:select", function(e) {
            idReason = e.params.data.id;
            $('#feeling').val("").trigger("change");
        });

        $('#feeling').select2({
            allowClear: true,
            ajax: {
                url: "{{ route('showfeeling') }}",
                type: 'GET',
                datatype: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        id: idReason
                    }
                },
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


        $('body').on('submit', '#wf-form-quote-form,#update_quote_form', function(e) {
            e.preventDefault();
            var formData = new FormData(this),
                dataAct = $(this).find('input:hidden[name=action]').val();

            if (dataAct == 'add') {
                $("#savedata").html('Sending..');
            }

            $.ajax({
                data: formData,
                url: "{{ route('quotes.store') }}",
                type: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (dataAct == 'edit') {
                        $("#update_quote_form").trigger("reset");
                        $('#author-update').val("").trigger('change');
                        $('#authorbook-update').val("").trigger('change');
                        $('#categories-update').val("").trigger('change');
                        $('#mood-update').val("").trigger('change');
                        $('#reason-update').val("").trigger('change');
                        $('#feeling-update').val("").trigger('change');
                        $('#editQuoteModal').modal('hide');
                    } else {
                        $('#wf-form-quote-form').trigger("reset");
                        $('#mood').val("").trigger("change");
                        $('#reason').val("").trigger("change");
                        $('#feeling').val("").trigger("change");
                        $('#author').val("").trigger("change");
                        $('#authorbook').val("").trigger("change");
                        $('#categories').val("").trigger("change");
                        $('#done-quote').show().delay(5000).fadeOut();
                        $('#addQuoteModal').modal('hide');
                    }

                    setTimeout(function() {
                        $('#quotes_table').DataTable().ajax.reload(null, false);
                        setChart(myChart, "akhir");
                        // $('.ajaxTable').DataTable().ajax.reload(null, false);
                    }, 1000);
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#fail-quote').show().delay(5000).fadeOut();
                }
            });

        });

        $('#country1').on('select2:unselect', function(e) {
            let tag = e.params.data;
            // tag = JSON.parse(tag);
            // alert(tag.id);
            dtag = tag.id + "," + dtag;
            $("#deltag").val(dtag);
        });
        
        $("#editlinkModal").on("hidden.bs.modal", function () {
            //alert("rset");
            $("#update_link_form").trigger('reset');
            $('#social-update').val("").trigger('change');
            
        });
    </script>
@endsection
