@extends('layouts.admin')
@section('title')
    Import
@endsection
@section('content')
    <div class="import-wrapper">
        <div class="import-input">
            <div class="import">
                <div class="w-form">
                    <form id="wf-form-import-form" name="wf-form-import-form" data-name="import-form" method="get"><label
                            class="titujt">Import</label><label for="file-import" class="teksti">Import
                            file</label><input type="text" class="w-input" maxlength="256" name="file-import"
                            data-name="file-import" placeholder="Example Text" id="file-import" required=""><label
                            for="language-import" class="teksti">Language</label><select id="language-import"
                            name="language-import" data-name="language-import" required="" class="select2 w-select">
                            <option value="">Select one...</option>
                            <option value="First">First choice</option>
                            <option value="Second">Second choice</option>
                            <option value="Third">Third choice</option>
                        </select>
                        &nbsp;
                        <a id="import-button" href="#" class="button-3 w-button">Import</a>
                    </form>
                    <div class="w-form-done">
                        <div>Thank you! Your submission has been received!</div>
                    </div>
                    <div class="w-form-fail">
                        <div>Oops! Something went wrong while submitting the form.</div>
                    </div>
                </div>
            </div>
            <a href="#" class="button w-button">Save</a>
        </div>
        <div class="import-list">
            <div class="titujt">Import List</div>
            <div class="import-table">
                <table class='table-striped' id='csv_list' data-toggle="table" data-url="get-list.php?table=csv_files"
                    data-click-to-select="false" data-side-pagination="server" data-pagination="true"
                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                    data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc"
                    data-mobile-responsive="true" data-show-export="false" data-maintain-selected="true"
                    data-query-params="queryParams">
                    <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">ID</th>
                            <th data-field="name" data-sortable="false">File</th>
                            <th data-field="language" data-sortable="true">Language</th>
                            <th data-field="created_at" data-sortable="true">Uploaded at</th>
                            <th data-field="operate" data-sortable="false" data-events="actionEvents"></th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function queryParams_1(p) {
            //var queryString = $('#advancedSearch').serialize();
            var searchInput = $(".bootstrap-table .fixed-table-toolbar .search input").val();
            //alert("search:"+searchInput);
            var param = {
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: searchInput,
                lang: $('#lang').val()
            }

            var advSearchFieldValue = $('#advancedSearch').serializeArray(),
                advCount = 0;
            $.each(advSearchFieldValue, function(index, fieldValuePair) {
                if (fieldValuePair.value != "") {
                    param[fieldValuePair.name] = fieldValuePair.value;
                    advCount++;
                }
            });

            if (advCount > 0) {
                param['advs'] = 1;
            }

            return param;

            //console.log('search:'+author);
        }
    </script>
@endsection
