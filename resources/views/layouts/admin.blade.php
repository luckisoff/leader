<!Doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <meta name="description" content="">

    <link rel="shortcut icon" href=" @if(Setting::get('site_icon')) {{ Setting::get('site_icon') }} @else {{asset('favicon.png') }} @endif">

    <link rel="stylesheet" href="{{ asset('admin-css/bootstrap/css/bootstrap.min.css')}}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('admin-css/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin-css/plugins/datatables/dataTables.bootstrap.css')}}">

    @yield('mid-styles')

    <link rel="stylesheet" href="{{ asset('admin-css/plugins/select2/select2.min.css')}}">

      <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-css/dist/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin-css/dist/css/skins/_all-skins.min.css')}}">

    <link rel="stylesheet" href="{{ asset('admin-css/dist/css/custom.css')}}">

    <link rel="stylesheet" href="https://unpkg.com/coreui/dist/css/coreui.min.css">
    
    @yield('styles')

   <?php echo Setting::get('header_scripts'); ?>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">

</head>


<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">

    <div class="wrapper">

        @include('layouts.admin.header')

        @include('layouts.admin.nav')

        <div class="content-wrapper">

            <section class="content-header">
                <h1>@yield('content-header')<small>@yield('content-sub-header')</small></h1>
                <ol class="breadcrumb">@yield('breadcrumb')</ol>
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>

        </div>

        <!-- include('layouts.admin.footer') -->

        <!-- include('layouts.admin.left-side-bar') -->

    </div>


    <!-- jQuery 2.2.0 -->
    <script src="{{asset('admin-css/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>
    <!-- Bootstrap 3.3.6 -->
    
    <script src="{{asset('admin-css/bootstrap/js/bootstrap.min.js')}}"></script>

    <script src="{{asset('admin-css/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{asset('admin-css/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

    <!-- Select2 -->
    <script src="{{asset('admin-css/plugins/select2/select2.full.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('admin-css/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{asset('admin-css/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>

    <script src="{{asset('admin-css/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

    <!-- SlimScroll -->
    <script src="{{asset('admin-css/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('admin-css/plugins/fastclick/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('admin-css/dist/js/app.min.js')}}"></script>

    <!-- jvectormap -->
    <script src="{{asset('admin-css/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>

    <script src="{{asset('admin-css/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    
    {{-- ck editor for specific routes --}}
    @if((Request::route()->getName()=='news.show-news-form')||(Request::route()->getName()=='news.edit-news-form'))
    <script src="{{asset('admin-css/plugins/ckeditor/ckeditor.js')}}"></script>
    <script>
        // CKEDITOR.editorConfig = function( config )
        // {
        //     config.extraPlugins = 'imageuploader';
        //     // config.toolbar =
        //     //     [
                    
        //     //         { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
        //     //         { name: 'editing', items: [ 'Scayt' ] },
        //     //         { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
        //     //         { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
        //     //         { name: 'tools', items: [ 'Maximize' ] },
        //     //         { name: 'document', items: [ 'Source' ] },
        //     //         '/',
        //     //         { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
        //     //         { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
        //     //         { name: 'styles', items: [ 'Styles', 'Format' ] },
        //     //         { name: 'about', items: [ 'About' ] }
        //     //     ];
        // };
        CKEDITOR.replace( 'ckeditor',{
            //extraPlugins: 'imageuploader',
        });
    </script>
    @endif
    {{-- <script src="{{asset('admin-css/plugins/chartjs/Chart.min.js')}}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="{{asset('admin-css/dist/js/pages/dashboard2.js')}}"></script> -->

    <script src="{{asset('admin-css/dist/js/demo.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- page script -->
    <script>
        $(function () {
            $("#example1").DataTable(
                // {
                //     dom: 'Bfrtip',
                //     buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                // }
            );
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "filtering":true,
                "ordering": false,
                "info": true,
                "autoWidth": false
            });
        });
        
    </script>
@if(Request::url()==route('audition.view-audition'))
 <script>
    $(document).ready(function () {
        $('#audition-table').DataTable({
            language: {
                processing: "<img src='../images/loader.gif'>",
            },
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{route('audition.ajax-audition') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "user_id" },
                { "data": "name" },
                { "data": "number" },
                { "data": "address" },
                { "data": "gender" },
                {"data":"email"},
                {"data":"payment_status"},
                {"data":"registration_code"},
                {"data":"payment_type"},
                {"data":"options"},

            ]	 

        });
    });
</script>
@endif
@if(Request::url()==route('admin.users'))
<script>
    $(document).ready(function () {
        $('#user-table').DataTable({
            language: {
                processing: "<img src='../images/loader.gif'>",
            },
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{route('admin.view.ajaxuser') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "mobile" },
                { "data": "level" },
                { "data": "point" },
                { "data": "status" },
                {"data":"options"},

            ]	 

        });
    });
</script>
@endif

    <script type="text/javascript">
        $("#{{$page}}").addClass("active");
        @if(isset($sub_page)) $("#{{$sub_page}}").addClass("active"); @endif
    </script>

    @yield('scripts')

   <?php  echo Setting::get('body_scripts'); ?>
</body>

</html>
