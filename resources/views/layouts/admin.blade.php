<!DOCTYPE html><!--  This site was created in Webflow. http://www.webflow.com  -->
<!--  Last Published: Mon May 30 2022 08:00:18 GMT+0000 (Coordinated Universal Time)  -->
<html data-wf-page="628e232b6202d858eb69e188" data-wf-site="628e232b6202d8e68069e187">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Webflow" name="generator">
    
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.css?').csrf_token() }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/normalize.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/solid.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/regular.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/brands.css') }}">
    <link href="{{ asset('css/webflow.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/thegoodquote-dashboard.webflow.css') }}" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rowReorder.dataTables.min.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.2/bootstrap-table.min.css" integrity="sha512-HIPiLbxNKmx+x+VFnDHICgl1nbRzW3tzBPvoeX0mq9dWP9H1ZGMRPXfYsHhcJS1na58bzUpbbfpQ/n4SIL7Tlw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    

    {{-- <script src="{{ asset('webfont.js') }}" type="text/javascript"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
    <script type="text/javascript">
        WebFont.load({
            google: {
                families: ["Poppins:100,200,300,regular,500,600,700,800,900"]
            }
        });
    </script>
    <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
    <script type="text/javascript">
        ! function(o, c) {
            var n = c.documentElement,
                t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n
                .className += t + "touch")
        }(window, document);
    </script>
    <link href="{{ asset('images/favicon.ico') }}" rel="shortcut icon" type="image/x-icon">
    <link href="{{ asset('images/webclip.png') }}" rel="apple-touch-icon">
</head>

<body class="body">
    @include('layouts.components.sidebar')
    @include('sweetalert::alert')
    @yield('content')


    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/webflow.js') }}" type="text/javascript"></script>
    <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <!--table -->
    <script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/c0632xaxnzlh76euyaony3i8eu0j7ngxpt0qki7t8hczjlm1/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    

    <script src="{{ asset('js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.rowReorder.min.js') }}"></script>
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap3-typeahead.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.2/bootstrap-table.min.js" integrity="sha512-9KY1w0S1bRPqvsNIxj3XovwFzZ7bOFG8u0K1LByeMVrzYhLu3v7sFRAlwfhBVFsHRiuMc6shv1lRLCTInwqxNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.20.2/bootstrap-table-locale-all.min.js" integrity="sha512-mlF5GOJPavMoUiUe9JvMA3mv4aBS6DqZ5TA2pE7MyAthrizH1RUTOOpeWItMWVJpXxUu6qpU/j+63VVvSHf0vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/export/bootstrap-table-export.min.js"></script>

    @yield('script')

    <script>
        $(function() {            
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        })
    </script>

</body>

</html>
