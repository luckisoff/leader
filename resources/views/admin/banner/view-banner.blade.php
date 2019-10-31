@extends('layouts.admin')

@section('title', 'Banner')

@section('content-header', 'Banner')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-bookmark"></i> Banner</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">

                    @if(count($banner) > 0)

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Banner Link</th>
                                <th>Instruction Text</th>
                                <th>Video Link</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($banner as $key =>  $value)

                                <tr>
                                    <td> {{ $key + 1 }}.</td>

                                    <td>
                                        <a href="{{ $value->banner_link }}" target="_blank">
                                            @if(strlen($value->banner_link) > 20 )
                                                {{ substr($value->banner_link,0,20) }}
                                            @else
                                                {{$value->banner_link}}
                                            @endif
                                        </a>
                                    </td>

                                    <td> {{  $value->instruction }} </td>

                                    <td>
                                        <a href="{{ $value->video_link }}" target="_blank">{{ $value->video_link }}</a>
                                    </td>

                                    <td>
                                        <img class="img img-responsive" style="max-width:100%; height: 100px;" src="{{asset($value->image)}}" alt="User Avatar">
                                    </td>

                                    <td>
                                        <ul class="admin-action btn btn-default">
                                            <li class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                    Action <span class="caret"></span>
                                                </a>

                                                <ul class="dropdown-menu">

                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="{{route('banner.edit-banner-form', array('id' => $value->id))}}">
                                                            <i class="fa fa-pencil"></i>Edit
                                                        </a>
                                                    </li>


                                                    <li role="presentation">
                                                        @if(Setting::get('admin_delete_control'))
                                                            <a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>
                                                        @else
                                                            <a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="{{route('banner.delete-banner',array('id' => $value->id))}}">
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