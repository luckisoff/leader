@extends('layouts.admin')

@section('title', 'Failed Payments')

@section('content-header', 'Failed Payments')

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

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Type</th>
                                <th>Log</th>
                                <th>Status</th>

                            </tr>
                            </thead>

                            <tbody>
                                @foreach($paymentlogs as $key =>  $value)
                                    @if($value->user)
                                        @if($value->user->audition && !$value->user->audition->payment_status)
                                            <tr>
                                                <td>{{$key + 1 }}</td>
                                                <td>{{$value->user->audition->name}}</td>
                                                <td>{{$value->user->audition->email}}</td>
                                                <td>{{$value->user->audition->number}}</td>
                                                <td>{{$value->type}}</td>
                                                <td>{{$value->value}}</td>
                                                <td>{{$value->created_at->diffForHumans()}}</td>
                                                {{-- <td>
                                                    <ul class="admin-action btn btn-default">
                                                        <li class="dropdown">
                                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                            Action <span class="caret"></span>
                                                            </a>

                                                            <ul class="dropdown-menu">
                                                            
                                                                <li role="presentation">
                                                                @if(Setting::get('admin_delete_control'))

                                                                    <a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>

                                                                @else
                                                                    <a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="#">
                                                                        Delete
                                                                    </a>
                                                                @endif
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    
                                                    </ul>
                                                </td> --}}
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

@endsection