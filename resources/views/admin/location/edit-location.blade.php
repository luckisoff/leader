@extends('layouts.admin')

@section('title', 'Edit Location')

@section('content-header', 'Edit Location')

@section('styles')
    {{--<link rel="stylesheet" href="{{asset('admin-css/plugins/datepicker/datepicker3.css')}}">--}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('location.view-location')}}"><i class="fa fa-users"></i>Show All Audition Location</a></li>
    <li class="active"><i class="fa fa-plus"></i> Edit Audition Location</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" action="{{route('location.edit-location')}}" method="POST" enctype="multipart/form-data" role="form">
                    <input type="hidden" name="location_id" value="{{ $location->id }}">
                    <div class="box-body">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="title" class="">Location Name <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="" name="location" value="{{ $location->location }}" placeholder="Enter Location Name">
                                @if($errors->has('location'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('location') }}
                                  </span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="video" class="">Venue <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="" value="{{ $location->venue }}" name="venue"  placeholder="Enter Venue" >
                                @if($errors->has('venue'))
                                    <span class="help-block" style="color:red;">
                                  * {{ $errors->first('venue') }}
                              </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="video" class="">Landmark <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="" value="{{ $location->landmark}}" name="landmark"  placeholder="Enter Landmark" >
                                @if($errors->has('landmark'))
                                    <span class="help-block" style="color:red;">
                                  * {{ $errors->first('landmark') }}
                              </span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="" class="">Latitude</label>
                                <input type="text"  class="form-control" name="latitude" value="{{ $location->latitude }}" placeholder="Enter Latitude">
                                @if($errors->has('latitude'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('latitude') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="" class="">Longitude</label>
                                <input type="text"  class="form-control" name="longitude" value="{{ $location->longitude }}" placeholder="Enter Longitude">
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
                        <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-pencil"></i> Update Location </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
@endsection


@section('scripts')

    <script src="{{asset('admin-css/plugins/datepicker/bootstrap-datepicker.js')}}"></script>

    <script type="text/javascript">

            $(function () {
                $('#datepicker').datepicker({
                    dateFormat: 'yyyy-mm-dd'
                });
            });
    </script>
@endsection