@extends('layouts.admin')

@section('title', 'Edit Judge')

@section('content-header', 'Edit Judge')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('judge.view-judge')}}"><i class="fa fa-shopping-cart"></i> Judge Listing</a></li>
    <li class="active"><i class="fa fa-pencil"></i> Edit Judge</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" action="{{route('judge.edit-judge')}}" method="POST" enctype="multipart/form-data" role="form">
                    <input type="hidden" name="judge_id" value="{{ $judge->id }}">
                    <div class="box-body">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="title" class="">Judge Name <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="" name="name" value="{{ $judge->name }}" placeholder="Enter Judge Name">
                                @if($errors->has('name'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('name') }}
                                  </span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="video" class="">Instagram Link</label>
                                <input type="text" class="form-control" id="" value="{{ $judge->insta_link }}" name="insta_link"  placeholder="Enter Instagram Link" >
                                @if($errors->has('insta_link'))
                                    <span class="help-block" style="color:red;">
                                  * {{ $errors->first('insta_link') }}
                              </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="video" class="">Facebook Link</label>
                                <input type="text" class="form-control" id="" value="{{ $judge->fb_link }}" name="fb_link"  placeholder="Enter Facebook Link" >
                                @if($errors->has('fb_link'))
                                    <span class="help-block" style="color:red;">
                                  * {{ $errors->first('fb_link') }}
                              </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="video" class="">Twitter Link</label>
                                <input type="text" class="form-control" id="" value="{{ $judge->twitter_link }}" name="twitter_link"  placeholder="Enter Twitter Link" >
                                @if($errors->has('twitter_link'))
                                    <span class="help-block" style="color:red;">
                                  * {{ $errors->first('twitter_link') }}
                              </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="" class="">Judge Image <span style="color:red;">*</span></label>

                                @if($judge->image != null )
                                    <img class="img img-responsive" style="max-width:100%; height: 100px;" src="{{asset($judge->image)}}" alt="User Avatar">
                                @endif

                                <input type="file" class="form-control" name="judge_image"   accept="image/jpeg,image/png" placeholder="{{tr('default_image')}}">
                                @if($errors->has('judge_image'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('judge_image') }}
                                  </span>
                                @endif
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <a href="{{ route('judge.view-judge') }}" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</a>
                        <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-check-circle"></i> Update Judge </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection