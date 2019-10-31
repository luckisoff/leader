@extends('layouts.admin')

@section('title', 'News')

@section('content-header', 'News')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li><a href="{{route('news.show-news-form')}}"><i class="fa fa-plus"></i>Add News</a></li>
    <li class="active"><i class="fa fa-bookmark"></i> News Listing</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">

                    @if(count($news) > 0)

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Video</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($news as $key =>  $value)

                                <tr>
                                    <td> {{ $key + 1 }}.</td>

                                    <td>
                                        {{ $value->title }}
                                    </td>

                                    <td> {{  str_limit($value->description,50) }} </td>

                                    <td>
                                        <img class="img img-responsive" style="max-width:100%; height: 100px;" src="{{asset($value->image)}}" alt="News Image">
                                    </td>

                                    <td>
                                        @if($value->video != null )
                                            <br>
                                            <a   style="max-width:100%; height: 100px;" href="{{asset($value->video)}}" alt="News Video " target="_blank">
                                                <i class="fa fa-music"> </i> PLay now </a>
                                        @else
                                            No Video
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
                                                        <a role="menuitem" tabindex="-1" href="{{route('news.edit-news-form', array('id' => $value->id))}}">
                                                            <i class="fa fa-pencil"></i>Edit
                                                        </a>
                                                    </li>


                                                    <li role="presentation">
                                                        @if(Setting::get('admin_delete_control'))
                                                            <a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>
                                                        @else
                                                            <a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="{{route('news.delete-news',array('id' => $value->id))}}">
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