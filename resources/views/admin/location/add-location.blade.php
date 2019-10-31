@extends('layouts.admin')

@section('title', 'Add Location')

@section('content-header', 'Add Location')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('location.view-location')}}"><i class="fa fa-shopping-cart"></i> View All Location</a></li>
    <li class="active"><i class="fa fa-plus"></i> Add Location</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" action="{{route('location.add-location')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="title" class="">Location Name <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="" name="location" value="{{ old('location') }}" placeholder="Enter Location Name">
                                @if($errors->has('location'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('location') }}
                                  </span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="video" class="">Venue <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="" value="{{ old('venue') }}" name="venue"  placeholder="Enter Venue" >
                                @if($errors->has('venue'))
                                    <span class="help-block" style="color:red;">
                                  * {{ $errors->first('venue') }}
                              </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="video" class="">Landmark <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="" value="{{ old('landmark')}}" name="landmark"  placeholder="Enter Landmark" >
                                @if($errors->has('landmark'))
                                    <span class="help-block" style="color:red;">
                                  * {{ $errors->first('landmark') }}
                              </span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="" class="">Latitude</label>
                                <input type="text"  class="form-control" name="latitude" value="{{ old("latitude") }}" placeholder="Enter Latitude">
                                @if($errors->has('latitude'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('latitude') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="" class="">Longitude</label>
                                <input type="text"  class="form-control" name="longitude" value="{{ old("longitude") }}" placeholder="Enter Longitude">
                                @if($errors->has('longitude'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('longitude') }}
                                  </span>
                                @endif
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger"><i class="fa fa-trash"></i> Reset</button>
                        <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-plus"></i> Add Location </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection