@extends('layouts.admin')

@section('title', 'Add News')

@section('content-header', 'Add News')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('banner.view-banner')}}"><i class="fa fa-bookmark"></i> News</a></li>
    <li class="active"><i class="fa fa-plus"></i> Add News</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-6">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" id="banner-add" action="{{route('news.add-news')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="title" class="">Title <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter News Title">
                                @if($errors->has('title'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('title') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description" class="">Description<span style="color:red;">*</span></label>
                                <textarea  style="overflow:auto;resize:none" placeholder="Enter Descripton" class="form-control"  required rows="4" cols="50" id="description" name="description">{{old('description') }}</textarea>
                                @if($errors->has('description'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('description') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="default_image" class="">Image Upload <span style="color:red;">*</span></label>
                                <input type="file" required class="form-control" name="image" id="default_image"  accept="image/jpeg,image/png" placeholder="{{tr('default_image')}}">
                                @if($errors->has('image'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('image') }}
                                  </span>
                                @endif
                            </div>

                            <div id="upload" >
                                <div class="form-group">
                                    <label for="video" class="">Video</label>
                                    <input type="file" class="form-control" name="video" id="video"  placeholder="{{tr('video')}}">
                                    @if($errors->has('video'))
                                        <span class="help-block" style="color:red;">
                                            * {{ $errors->first('video') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger"><i class="fa fa-redo"></i>Reset</button>
                        <button type="submit" class="btn btn-success pull-right"> Upload News </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection