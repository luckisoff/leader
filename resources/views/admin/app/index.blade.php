@extends('layouts.admin')

@section('title', 'Apps Listing')

@section('content-header', 'Apps Listing')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-shopping-basket"></i> Apps Listing</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">
                    <a href="{{route('createapp')}}"><span class="fa fa-plus"> New App</span></a>
                    <hr>
                    @if(count($apps) > 0)

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>App Name</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                            </thead>

                            <tbody>
                                @foreach($apps as $key =>  $value)

                                <tr>
                                    <td> {{ $key + 1 }}.</td>

                                    <td> {{$value->name }}</td>

                                    <td>
                                        @if($value->status==1)
                                            <span class="label label-success">On</span>
                                        @else
                                            <span class="label label-danger">Off</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="admin-action btn btn-default">
                                            <li class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                    Action <span class="caret"></span>
                                                </a>

                                                <ul class="dropdown-menu">  

                                                        <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="{{route('createapp', array('id' => $value->id))}}">
                                                                    <i class="fa fa-pencil"></i>Edit
                                                                </a>
                                                            </li>

                                                    <li role="presentation">
                                                        @if(Setting::get('admin_delete_control'))
                                                            <a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>
                                                        @else
                                                    <a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="{{route('appdelete',['app'=>$value])}}">
                                                                <i class="fa fa-trash"></i>Delete
                                                            </a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </td>
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

@endsection