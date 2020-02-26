@extends('layouts.admin')

@section('title', tr('edit_story'))

@section('content-header', tr('edit_story'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('admin.stories')}}"><i class="fa fa-suitcase"></i> {{tr('stories')}}</a></li>
    <li class="active">{{tr('edit_story')}}</li>
@endsection

@section('content')

@include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" action="{{route('admin.save.story')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <input type="hidden" name="id" value="{{$story->id}}">

                        <div class="form-group">
                            <label for="name" class="col-sm-1 control-label">{{tr('Name')}}</label>
                            <div class="col-sm-10">
                                <input type="text" required class="form-control" value="{{$story->name}}" id="name" name="name" placeholder="Story Name">
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="categories" class="col-sm-1 control-label">{{tr('Category')}}</label>
                            <div class="col-sm-10">
                                
                                <select id="category" name="category_id" class="form-control">
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$story->category_id==$category->id?'selected':''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="types" class="col-sm-1 control-label">{{tr('Type')}}</label>
                            <div class="col-sm-10">
                                <select id="type" name="type" class="form-control">
                                   <option value="image" {{$story->type=='image'?'selected':''}}>Image</option>
                                   <option value="video" {{$story->type=='video'?'selected':''}}>Video</option>
                                   <option value="ad" {{$story->type=='ad'?'selected':''}}>Ad</option>
                                </select>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label for="picture" class="col-sm-1 control-label">{{tr('Content')}}</label>
                            <div class="col-sm-10" style="">
                                <input type="file" class="form-control" accept="image/png,image/jpeg" id="picture" name="picture" placeholder="{{tr('picture')}}">
                                 <p class="help-block">Please choose a video or an image file</p>
                            </div>
                            
                        </div>
                        <div class="form-group">
                        <label for="picture" class="col-sm-1 control-label"></label>
                            <div class="col-sm-10">
                                @if($story->picture && $story->type=='image')
                                    <img style="height: 90px;margin-bottom: 15px; border-radius:2em;" src="{{$story->picture}}">
                                @else
                                    <video width="150" height="85" controls>
                                        <source src="{{$story->picture}}">
                                        Your browser does not support this video
                                    </video>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger">{{tr('cancel')}}</button>
                        <button type="submit" class="btn btn-success pull-right">{{tr('submit')}}</button>
                    </div>
                </form>
            
            </div>

        </div>

    </div>

@endsection