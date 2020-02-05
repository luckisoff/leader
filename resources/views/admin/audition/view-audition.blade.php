@extends('layouts.admin')

@section('title', 'View Audition Registration List')

@section('content-header', 'View Audition Registration List')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-bookmark"></i> View Audition Registration List</li>
@endsection

@section('css')

@endsection

@section('content')

    @include('notification.notify')


    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">

                        <div class="table-responsive">
                            <table id="audition-table" class="table  table-bordered table-striped" style="width:100%">

                            <thead>
                                <tr class="">
                                <td colspan="11">
                                    <a href="{{route('audition.export-excel')}}">
                                        <span class="fa fa-file-excel-o"> Export to Excel</span>
                                    </a>
                                </td>
                                </tr>
                                <tr style="background: #16008e;color: #fff;font-size: 15px;">
                                    <td colspan="3">Total: {{' '.$totalUsers.' '}} (Today:{{' '.$todayNewUsers}})</td>
                                    <td colspan="2">Registered: {{' '.$totalRegistered.' '}} (Today:{{' '.$todayRegistered}})</td>
                                    <td colspan="2">Esewa: {{' '.$esewaUsers}}</td>
                                    <td colspan="2">Khalti: {{' '.$khaltiUsers}}</td>
                                    <td colspan="2">Paypal: {{' '.$paypalUsers}}</td>
                                </tr>
                                <tr>
                                    <th>S.N.</th>
                                    <th>User Id</th>
                                    <th>Contestant Name</th>
                                    <th>Contact Number</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>Email </th>
                                    <th>Payment Status</th>
                                    <th>Payment Code</th>
                                    <th>Payment Option</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection