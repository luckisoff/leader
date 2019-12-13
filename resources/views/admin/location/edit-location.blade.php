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
                                <label for="video" class="">Country<span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="" value="{{ $location->country}}" name="country"  placeholder="Enter Country" >
                                @if($errors->has('country'))
                                    <span class="help-block" style="color:red;">
                                  * {{ $errors->first('country') }}
                              </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="video" class="">City<span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" id="" value="{{ $location->city}}" name="city"  placeholder="Enter City" >
                                @if($errors->has('city'))
                                    <span class="help-block" style="color:red;">
                                  * {{ $errors->first('city') }}
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
                            <div class="form-group">
                                <label for="" class="">Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="nepal" {{$location->type=='nepal'?'selected':''}}>Nepal</option>
                                    <option value="international" {{$location->type=='international'?'selected':''}}>International</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="" class="">Loation Image <span style="color:red;">*</span></label>
                                @if($location->image != null )
                                    <img class="img img-responsive" style="max-width:100%; height: 100px;" src="{{asset($location->image)}}" alt="User Avatar">
                                @endif
                                <input type="file" class="form-control" name="image"   accept="image/jpeg,image/png" placeholder="{{tr('default_image')}}">
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