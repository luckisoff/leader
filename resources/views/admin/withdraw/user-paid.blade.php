@extends('layouts.admin')

@section('title', 'Withdraw Claims')

@section('content-header', 'Withdraw Claims')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-shopping-basket"></i>Withdraw Claims</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">
                <h4>Paid Lists</h4>
                <hr>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Type</th>
                        <th>Amount Claimed</th>
                        <th>Balance</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach($withdrawPaids as $key =>  $value)

                        <tr>
                            <td>{{$key + 1 }}</td>
                            <td>{{$value->user->name }}</td>
                            <td>
                                <img src="{{$value->user->picture}}" class="img-responsive" style="height:50px">
                            </td>
                            <td>{{$value->user->email}}</td>
                            <td>{{$value->mobile}}</td>
                            <td>{{ucfirst($value->type)}}</td>
                            <td>{{'Rs. '.number_format($value->amount,2,'.','').' (Level: '.$value->user->leaderboard->first()->level.')'}}</td>
                            <td>{{'Rs. '.number_format($value->user->leaderBoard->first()->point,2,'.','')}}</td>
                            <td>
                                {{$value->status==1?'Paid':'Unpaid'}}
                                <br>
                                {{$value->updated_at->diffForHumans()}}    
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

@endsection