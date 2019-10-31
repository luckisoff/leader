@extends('layouts.admin')

@section('title', 'Update News')

@section('content-header', 'Update News')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('banner.view-banner')}}"><i class="fa fa-bookmark"></i> View News</a></li>
    <li class="active"><i class="fa fa-pencil"></i> Update Banner</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-6">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" id="news-add" action="{{route('news.edit-news')}}" method="POST" enctype="multipart/form-data" role="form">
                    <input type="hidden" name="news_id" value="{{ $news->id }}">

                    <div class="box-body">

                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="title" class="">Title <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="title" name="title" value="{{ $news->title ?? old('title') }}" placeholder="Enter News Title">
                                @if($errors->has('title'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('title') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description" class="">Description<span style="color:red;">*</span></label>
                                <textarea  style="overflow:auto;resize:none" placeholder="Enter Descripton" class="form-control"  required rows="4" cols="50" id="description" name="description">{{ $news->description }}</textarea>
                                @if($errors->has('description'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('description') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="default_image" class="">Image Upload <span style="color:red;">*</span></label>

                                @if($news->image != null )
                                    <img class="img img-responsive" style="max-width:100%; height: 100px;" src="{{asset($news->image)}}" alt="News Image">
                                    <br>
                                @endif

                                <input type="file" class="form-control" name="image" id="default_image"  accept="image/jpeg,image/png" placeholder="{{tr('default_image')}}">
                                @if($errors->has('image'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('image') }}
                                    </span>
                                @endif
                            </div>

                            <div id="upload" >
                                <div class="form-group">
                                    <label for="video" class="">Video</label>
                                    @if($news->video!= null )
                                        <br>
                                        <a   style="max-width:100%; height: 100px;" href="{{asset($news->video)}}" alt="Attachment MP3 file" target="_blank">
                                            <i class="fa fa-music"> </i> PLay now </a>
                                    @endif

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