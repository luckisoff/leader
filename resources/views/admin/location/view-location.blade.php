@extends('layouts.admin')

@section('title', 'Location Listing')

@section('content-header', 'Location Listing')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-shopping-basket"></i> Location Listing</li>
@endsection

@section('styles')

@endsection

@section('content')

    @include('notification.notify')

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">

                    @if(count($location) > 0)

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Location</th>
                                <th>Venue</th>
                                <th>Landmark</th>
                                <th> Map</th>
                                <th>Action</th>

                            </tr>
                            </thead>

                            <tbody>
                                @foreach($location as $key =>  $value)

                                <tr>
                                    <td> {{ $key + 1 }}.</td>

                                    <td> {{$value->location }}</td>

                                    <td>
                                        {{ $value->venue }}
                                    </td>

                                    <td>
                                        {{ ($value->landmark)}}
                                    </td>

                                    <td>
                                        @if(!empty($value->latitude) && !empty($value->longitude))
                                                <a target="_blank" href="{{'https://www.google.com/maps/place/'.$value->latitude.','.$value->longitude}}">
                                                    <i class="fa fa-map-marker"></i>
                                                    Show in Map
                                                </a>
                                        @else
                                            No Coordinates
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
                                                        <a role="menuitem" tabindex="-1" href="{{route('location.edit-location-form', array('id' => $value->id))}}">
                                                            <i class="fa fa-pencil"></i>Edit
                                                        </a>
                                                    </li>


                                                    <li role="presentation">
                                                        @if(Setting::get('admin_delete_control'))

                                                            <a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>

                                                        @else
                                                            <a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="{{route('location.delete-location',array('id' => $value->id))}}">
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