@extends('layouts.admin')

@section('title', 'Update Banner')

@section('content-header', 'Update Banner')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('banner.view-banner')}}"><i class="fa fa-bookmark"></i> View Banner</a></li>
    <li class="active"><i class="fa fa-pencil"></i> Update Banner</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" id="banner-add" action="{{route('banner.edit-banner')}}" method="POST" enctype="multipart/form-data" role="form">
                    <input type="hidden" name="banner_id" value="{{ $banner->id }}">
                    <div class="box-body">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="title" class="">Link <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="title" name="banner_link" value="{{ $banner->banner_link }}" placeholder="Enter Link">
                                @if($errors->has('banner_link'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('banner_link') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description" class="">Instruction<span style="color:red;">*</span></label>
                                <textarea  style="overflow:auto;resize:none" placeholder="Enter Instruction Text" class="form-control"  required rows="4" cols="50" id="instruction" name="instruction">{{ $banner->instruction }}</textarea>
                                @if($errors->has('instruction'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('instruction') }}
                                  </span>
                                @endif
                            </div>

                        </div>

                        <div class="col-md-1">
                        </div>

                        <div class="col-md-5">

                            <div class="form-group">
                                <label for="default_image" class="">Image Upload <span style="color:red;">*</span></label>
                                @if($banner->image != null )
                                    <img class="img img-responsive" style="max-width:100%; height: 100px;" src="{{asset($banner->image)}}" alt="User Avatar">
                                @endif

                                <input type="file"  class="form-control" name="image" id="default_image"  accept="image/jpeg,image/png" placeholder="{{tr('default_image')}}">

                                @if($errors->has('image'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('image') }}
                                  </span>
                                @endif
                            </div>

                            <div id="upload" >
                                <div class="form-group">
                                    <label for="video" class="">Video Link</label>
                                    <input type="text" class="form-control" id="video_link" name="video_link" value="{{ $banner->video_link }}"  placeholder="Enter Video Link" >
                                    @if($errors->has('video_link'))
                                        <span class="help-block" style="color:red;">
                                            * {{ $errors->first('video_link') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <a href="{{ route('banner.view-banner') }}" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</a>
                        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check-circle"></i> Update </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection