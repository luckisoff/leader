@extends('layouts.admin')

@section('title', tr('add_story'))

@section('content-header', tr('add_story'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('admin.categories')}}"><i class="fa fa-suitcase"></i> {{tr('stories')}}</a></li>
    <li class="active">{{tr('add_story')}}</li>
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

                        <div class="form-group">
                            <label for="name" class="col-sm-1 control-label">{{tr('name')}}</label>
                            <div class="col-sm-10">
                                <input type="text" required class="form-control" id="name" name="name" placeholder="Story  Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="picture" class="col-sm-1 control-label">{{tr('picture')}}</label>
                            <div class="col-sm-10">
                                <input type="file" required class="form-control" id="picture" accept="image/png,image/jpeg" name="picture" placeholder="{{tr('picture')}}">
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label for="categories" class="col-sm-1 control-label">{{tr('Category')}}</label>
                            <div class="col-sm-10">
                                
                                <select id="category" name="category_id" class="form-control">
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                
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