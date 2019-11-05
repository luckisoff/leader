@extends('layouts.admin')

@section('title', 'Earnings')

@section('content-header', 'Earnings of '.$user->name)

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
<li class="active"><i class="fa fa-bookmark"></i> Earnings</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">
                    
                    @if(count($earnings) > 0)
                    <a href="#" onclick="exportToExcel(this,'{{$user->name}}');"><i class="fa fa-download"> To Excel</i></a>
                    <hr>
                        <table id="example1" class="table table-bordered table-striped display nowrap">

                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Set Name</th>
                                <th>Level</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($earnings as $key =>  $value)

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{$value->set?$value->set:'No Info'}}</td>
                                    <td>{{$value->level?$value->level:'No Info'}}</td>
                                    <td>{{$value->amount}}</td>
                                    <td>{{$value->created_at}}</td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h3 class="no-result">No results found</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function exportToExcel(elem,name) {
            var table = document.getElementById("example1");
            var html = table.outerHTML;
            var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
            elem.setAttribute("href", url);
            elem.setAttribute("download", name+".xls"); // Choose the file name
            return false;
        }     
    </script>
@endsection