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
                            <label for="name" class="col-sm-1 control-label">{{tr('name')}}</label>
                            <div class="col-sm-10">
                                <input type="text" required class="form-control" value="{{$story->name}}" id="name" name="name" placeholder="Story Name">
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="categories" class="col-sm-1 control-label">{{tr('category')}}</label>
                            <div class="col-sm-10">
                                
                                <select id="category" name="category_id" class="form-control">
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$story->category_id==$category->id?'selected':''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                        

                        <div class="form-group">

                            <label for="picture" class="col-sm-1 control-label">{{tr('picture')}}</label>

                            @if($story->picture)
                                <img style="height: 90px;margin-bottom: 15px; border-radius:2em;" src="{{$story->picture}}">
                            @endif

                            <div class="col-sm-10" style="margin-left:70px !important">
                                <input type="file" class="form-control" accept="image/png,image/jpeg" id="picture" name="picture" placeholder="{{tr('picture')}}">
                                 <p class="help-block">Please enter .png .jpeg .jpg images only.</p>
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