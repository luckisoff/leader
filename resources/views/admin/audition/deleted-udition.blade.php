@extends('layouts.admin')

@section('title', 'Deleted Audition List')

@section('content-header', 'Deleted Audition List')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-bookmark"></i> Deleted Audition List</li>
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
                            <table id="example1" class="table  table-bordered table-striped" style="width:100%">

                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Admin Name</th>
                                    <th>Admin Email</th>
                                    <th>Admin Ip</th>
                                    <th>User Name</th>
                                    <th>User Status</th>
                                    <th>Deleted on</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($auditions as $key=>$audition)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$audition->admin->name}}</td>
                                        <td>{{$audition->admin->email}}</td>
                                        <td>{{$audition->ip}}</td>
                                        <td>{{$audition->audition->name}}</td>
                                        <td>{{$audition->audition->payment_status==1?'Paid':'Unpaid'}}</td>                                        <td>{{$audition->audition->name}}</td>
                                        <td>{{$audition->audition->deleted_at->diffForHumans()}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection