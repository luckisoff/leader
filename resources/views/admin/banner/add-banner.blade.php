@extends('layouts.admin')

@section('title', 'Add Banner')

@section('content-header', 'Add Banner')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('banner.view-banner')}}"><i class="fa fa-bookmark"></i> Banner</a></li>
    <li class="active"><i class="fa fa-plus"></i> Add Banner</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" id="banner-add" action="{{route('banner.add-banner')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="title" class="">Link <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="title" name="banner_link" value="{{ old('banner_link') }}" placeholder="Enter Link">
                                @if($errors->has('banner_link'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('banner_link') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description" class="">Instruction<span style="color:red;">*</span></label>
                                <textarea  style="overflow:auto;resize:none" placeholder="Enter Instruction Text" class="form-control"  required rows="4" cols="50" id="instruction" name="instruction">{{old('instruction') }}</textarea>
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
                                <input type="file" required class="form-control" name="image" id="default_image"  accept="image/jpeg,image/png" placeholder="{{tr('default_image')}}">
                                @if($errors->has('image'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('image') }}
                                  </span>
                                @endif
                            </div>

                            <div id="upload" >
                                <div class="form-group">
                                    <label for="video" class="">Video Link</label>
                                    <input type="text" class="form-control" id="video_link" name="video_link" value="{{ old('video_link') }}"  placeholder="Enter Video Link" >
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
                        <button type="reset" class="btn btn-danger"><i class="fa fa-redo"></i>Reset</button>
                        <button type="submit" class="btn btn-success pull-right"> Upload Video </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection