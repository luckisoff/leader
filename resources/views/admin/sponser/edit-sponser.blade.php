@extends('layouts.admin')

@section('title', 'Edit Sponser')

@section('content-header', 'Edit Sponser')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('banner.view-banner')}}"><i class="fa fa-shopping-cart"></i> Sponser</a></li>
    <li class="active"><i class="fa fa-plus"></i> Edit Sponser</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" id="sponser-add" action="{{route('sponser.edit-sponser')}}" method="POST" enctype="multipart/form-data" role="form">
                    <input type="hidden" name="sponser_id" value="{{ $sponser->id }}">
                    <div class="box-body">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="title" class="">Sponser and Partner Name <span style="color:red">*</span></label>
                                <input type="text" required class="form-control" id="" name="name" value="{{ $sponser->name }}" placeholder="Enter Sponser and Partner Name">
                                @if($errors->has('name'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('name') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description" class="">Partner Type <span style="color:red">*</span></label>
                                <input type="text" required class="form-control" id="" name="partner_type" value="{{ $sponser->partner_type }}" placeholder="Enter Sponser and Partner Type">
                                @if($errors->has('partner_type'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('partner_type') }}
                                  </span>
                                @endif
                            </div>

                            <div id="upload" >
                                <div class="form-group">
                                    <label for="video" class="">Link <span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="" name="link" value="{{ $sponser->link }}"  placeholder="Enter Sponser and Partner Link" >
                                    @if($errors->has('link'))
                                        <span class="help-block" style="color:red;">
                                      * {{ $errors->first('link') }}
                                  </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image" class="">Image Upload <span style="color:red">*</span></label>

                                @if($sponser->image != null )
                                    <img class="img img-responsive" style="max-width:100%; height: 100px;" src="{{asset($sponser->image)}}" alt="Sponser Image">
                                @endif

                                <input type="file"  class="form-control" name="image" id="image"  accept="image/jpeg,image/png" placeholder="{{tr('default_image')}}">
                                @if($errors->has('image'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('image') }}
                                  </span>
                                @endif
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <a href="{{ route('sponser.view-sponser') }}" class="btn btn-danger"><i class="fa fa-times-circle"></i> Cancel</a>
                        <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-check-circle"></i> Update Sponser </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection