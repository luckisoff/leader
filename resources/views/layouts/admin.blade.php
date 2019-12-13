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


<body class="hold-transition skin-blue sidebar-mini">

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
            $('#example1').DataTable({
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



    <script type="text/javascript">
        $("#{{$page}}").addClass("active");
        @if(isset($sub_page)) $("#{{$sub_page}}").addClass("active"); @endif
    </script>

    @yield('scripts')

   <?php echo Setting::get('body_scripts'); ?>
   @if(isset($leaderboards))
   <script>
    //    var ctx = document.getElementById('myChart');
    //    var myBarChart = new Chart(ctx, {
    //         type: 'bar',
    //         data: {
    //             labels:[@foreach($leaderboards as $leaderboard)"{{$leaderboard->user['name']}}",@endforeach],
    //             datasets: [{
    //                     barPercentage: 0.5,
    //                     barThickness: 6,
    //                     maxBarThickness: 8,
    //                     minBarLength: 2,
    //                     label: 'Rs Total (Top 10)',
    //                     data: [@foreach($leaderboards as $leaderboard){{$leaderboard->point}},@endforeach],
    //                     backgroundColor : [
    //                         @php($colors=['pink','violet','red','green', 'blue', 'purple','magenta','orange','red'])
    //                         @foreach($leaderboards as $leaderboard)
    //                             "{{$colors[array_rand($colors)] }}",
    //                         @endforeach
    //                     ],
    //                     borderColor : [
    //                         @foreach($leaderboards as $leaderboard)
    //                             "#111",
    //                         @endforeach
    //                     ],
    //                 }]
    //             },
    //     });
    </script>
    @endif
</body>

</html>
