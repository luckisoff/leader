@extends('layouts.admin')

@section('title', 'Judge Listing')

@section('content-header', 'Judge Listing')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-shopping-basket"></i> Judge Listing</li>
@endsection

@section('styles')
    <style>
        .instagram {
            display: inline-block;
            width: 25px;
            height: 25px;
            text-align: center;
            border-radius: 50px;
            color: #fff;
            font-size: 20px;
            line-height: 25px;
            vertical-align: middle;
            background: #d6249f;
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%);
            box-shadow: 0px 3px 10px rgba(0,0,0,.25);
        }
    </style>

@endsection

@section('content')

    @include('notification.notify')

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">

                    @if(count($judge) > 0)

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Judge Name</th>
                                <th>Social Media</th>
                                <th>Image</th>
                                <th>Action</th>

                            </tr>
                            </thead>

                            <tbody>
                                @foreach($judge as $key =>  $value)

                                <tr>
                                    <td> {{ $key + 1 }}.</td>

                                    <td> {{$value->name }}</td>

                                    <td>
                                        @if(!empty($value->fb_link))
                                            <a href="{{$value->fb_link}}"  target="_blank">
                                                <i style="font-size: 25px" class="fa fa-facebook-square"></i>
                                            </a> &nbsp;
                                        @endif

                                        @if(!empty($value->insta_link))
                                            <a href="{{$value->insta_link}}"  target="_blank">
                                                <i style="font-size: 25px; color: #00acee " class="fa fa-twitter-square"></i>
                                            </a> &nbsp;
                                        @endif

                                        @if(!empty($value->twitter_link))
                                                <a href="{{$value->twitter_link}}"  target="_blank">
                                                    {{--<i  style="font-size: 25px; color: #3f729b" class="fa fa-instagram"></i>--}}
                                                    <i style="margin-top:-10px; ;"  class="fa fa-instagram instagram"></i>
                                                </a>
                                        @endif

                                        @if(empty($value->fb_link) && empty($value->insta_link) && empty($value->twitter_link) )
                                            <p style="color:darkred"> No Links</p>
                                        @endif
                                    </td>

                                    <td>
                                        <img class="img img-responsive" style="max-width:100%; height: 100px;" src="{{asset($value->image)}}" alt="Sponser Image">
                                    </td>

                                    <td>
                                        <ul class="admin-action btn btn-default">
                                            <li class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                    Action <span class="caret"></span>
                                                </a>

                                                <ul class="dropdown-menu">

                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="{{route('judge.edit-judge-form', array('id' => $value->id))}}">
                                                            <i class="fa fa-pencil"></i>Edit
                                                        </a>
                                                    </li>


                                                    <li role="presentation">
                                                        @if(Setting::get('admin_delete_control'))

                                                            <a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>

                                                        @else
                                                            <a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="{{route('judge.delete-judge',array('id' => $value->id))}}">
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
                           {{-- @foreach($view_pages as $i => $data)

                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$data->heading}}</td>
                                    <td>{{$data->description}}</td>
                                    <td>{{$data->type}}</td>
                                    <td>
                                        <ul class="admin-action btn btn-default">
                                            <li class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                    Action <span class="caret"></span>
                                                </a>

                                                <ul class="dropdown-menu">

                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="{{route('editPage', array('id' => $data->id))}}">
                                                            Edit Page
                                                        </a>
                                                    </li>


                                                    <li role="presentation">
                                                        @if(Setting::get('admin_delete_control'))

                                                            <a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>

                                                        @else
                                                            <a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="{{route('deletePage',array('id' => $data->id))}}">
                                                                Delete Page
                                                            </a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </td>
                                </tr>
                            @endforeach--}}
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