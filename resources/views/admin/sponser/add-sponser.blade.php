@extends('layouts.admin')

@section('title', 'Add Sponser')

@section('content-header', 'Add Sponser')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('banner.view-banner')}}"><i class="fa fa-shopping-cart"></i> Sponser</a></li>
    <li class="active"><i class="fa fa-plus"></i> Add Sponser</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" id="sponser-add" action="{{route('sponser.add-sponser')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="title" class="">Sponser and Partner Name</label>
                                <input type="text" required class="form-control" id="" name="name" placeholder="Enter Sponser and Partner Name">
                                @if($errors->has('name'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('name') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description" class="">Partner Type</label>
                                <input type="text" required class="form-control" id="" name="partner_type" placeholder="Enter Sponser and Partner Type">
                                @if($errors->has('partner_type'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('partner_type') }}
                                  </span>
                                @endif
                            </div>

                            <div id="upload" >
                                <div class="form-group">
                                    <label for="video" class="">Link</label>
                                    <input type="text" class="form-control" id="" name="link"  placeholder="Enter Sponser and Partner Link" >
                                    @if($errors->has('link'))
                                        <span class="help-block" style="color:red;">
                                      * {{ $errors->first('link') }}
                                  </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image" class="">Image Upload</label>
                                <input type="file" required class="form-control" name="image" id="image"  accept="image/jpeg,image/png" placeholder="{{tr('default_image')}}">
                                @if($errors->has('image'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('image') }}
                                  </span>
                                @endif
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger"><i class="fa fa-trash"></i> Reset</button>
                        <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-plus"></i> Add Sponser </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection