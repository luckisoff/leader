@extends('layouts.admin')

@section('title', 'Edit Contestant')

@section('content-header', 'Edit Contestant')

@section('styles')
{{--    <link rel="stylesheet" href="{{asset('admin-css/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">--}}
    <link rel="stylesheet" href="{{asset('admin-css/plugins/datepicker/datepicker3.css')}}">
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('audition.view-audition')}}"><i class="fa fa-users"></i>Show All Audition Constestant</a></li>
    <li class="active"><i class="fa fa-plus"></i> Edit  Audition User</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" id="" action="{{route('audition.edit-audition')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <div class="col-md-6">
                            <input type="hidden" name="crsf" value="{{ csrf_token() }}">
                            <input type="hidden" name="contestant_id" value="{{ $contestant->id }}">
                            <div class="form-group">
                                <label for="" class="">Contestant Name <span style="color:red;">*</span></label>
                                <input type="text" required value="{{ ( (old('name') == null) ?  $contestant->name : old('name')) }}"  class="form-control" id="" name="name" placeholder="Enter Contestant Name">
                                @if($errors->has('name'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('name') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="" class="">Gender <span style="color:red;">*</span></label>
                                <select class="form-control" id="" name="gender">
                                    <option value="">Select Any One</option>
                                    <option value="male" @if( ( (old('gender') == null) ?  $contestant->gender : old('gender'))  == "male") selected @endif> Male</option>
                                    <option value="female" @if(( (old('gender') == null) ?  $contestant->gender : old('gender')) == "female") selected @endif>Female</option>
                                    <option value="others" @if( ( (old('gender') == null) ?  $contestant->gender : old('gender')) == "others") selected @endif>Others</option>
                                </select>
                                @if($errors->has('gender'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('gender') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="" class="">Address<span style="color:red;">*</span></label>
                                <input type="text" required  class="form-control" id="" value="{{ ( (old('address') == null) ?  $contestant->address : old('address')) }}" name="address" placeholder="Enter  Address">
                                @if($errors->has('address'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('address') }}
                                  </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-1">
                        </div>

                        <div class="col-md-5">

                            <div class="form-group">
                                <label for="" class="">Contact Number <span style="color:red;">*</span></label>
                                <input type="number" required class="form-control" id="" name="number" value="{{ ( (old('number') == null) ?  $contestant->number : old('number')) }}"  placeholder="Enter Contact Number " >
                                @if($errors->has('number'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('number') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="" class="">Email <span style="color:red;">*</span></label>
                                <input type="email" required  class="form-control" id="" name="email" value="{{ ( (old('email') == null) ?  $contestant->email : old('email')) }}" placeholder="Enter Email Address">
                                @if($errors->has('email'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('email') }}
                                  </span>
                                @endif
                            </div>

                        </div>

                       {{-- <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <h3>Document Upload </h3>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="">Id Type <span style="color:red;">*</span></label>
                                        <select class="form-control" required id="" name="id_type"  >
                                            <option value="">Select Any One</option>
                                            <option value="citizenship" @if($contestant->id_type == "citizenship") selected @endif>Citizenship</option>
                                            <option value="passort" @if($contestant->id_type == "passort") selected @endif>Passport </option>
                                            <option value="driving_license" @if($contestant->id_type == "driving_license") selected @endif>Driving License</option>
                                        </select>
                                        @if($errors->has('id_type'))
                                            <span class="help-block" style="color:red;">
                                                  * {{ $errors->first('id_type') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="">Issued Place</label>
                                        <input type="text"  class="form-control" id="" name="issued_place"  value="{{ $contestant->issue_place }}" placeholder="Enter Issued Place">
                                    </div>

                                    <div class="form-group">
                                        <label for="default_image" class="">Document Upload</label>
                                        @if($contestant->image != null )
                                        <img class="img img-responsive" style="max-width:100%; height: 100px;" src="{{asset($contestant->image)}}" alt="User Avatar">
                                        @endif
                                        <input type="file"  class="form-control" name="image" id="default_image"  accept="image/jpeg,image/png" placeholder="{{tr('default_image')}}">
                                    </div>

                                </div>

                                <div class="col-md-1"></div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="" class="" >Id Number <span style="color:red;">*</span></label>
                                        <input type="text" required  class="form-control" id="" name="id_number" value="{{ $contestant->id_number }}" placeholder="Enter ID Number ">
                                        @if($errors->has('id_number'))
                                            <span class="help-block" style="color:red;">
                                                  * {{ $errors->first('id_number') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="">Issued Date</label>
                                        <input type="text" data-date-format="yyyy-mm-dd" value="{{ $contestant->issue_date }}"  class="form-control" autocomplete="off" name="issued_date" placeholder="Enter Issued Date" id="datepicker">
                                    </div>

                                    <div class="form-group">
                                        <label for="default_image" class="">Attachment</label>
                                        @if($contestant->attachment != null )
                                            <br>
                                            <a   style="max-width:100%; height: 100px;" href="{{asset($contestant->attachment)}}" alt="Attachment MP3 file" target="_blank">
                                                <i class="fa fa-music"> </i> PLay now </a>
                                        @endif
                                        <input type="file"  class="form-control" name="attachment"  placeholder="{{tr('default_image')}}">
                                    </div>

                                </div>
                            </div>
                        </div>--}}

                    </div>

                    <div class="box-footer">
                        <a href="{{ route('audition.view-audition') }}"  class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check-circle"></i> Update </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection


@section('scripts')

{{--    <script src="{{asset('admin-css/plugins/bootstrap-datetimepicker/js/moment.min.js')}}"></script>--}}
{{--    <script src="{{asset('admin-css/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>--}}
    <script src="{{asset('admin-css/plugins/datepicker/bootstrap-datepicker.js')}}"></script>

    <script type="text/javascript">

        $(function () {

            /*  $('#datepicker').datetimepicker({
                  // minTime: "00:00:00",
                  dateFormat: 'yy-mm-dd'
                  // minDate: moment(),
              });
          });*/

            $(function () {
                $('#datepicker').datepicker({
                    dateFormat: 'yyyy-mm-dd'
                });
                // var h = $('#datepicker').datepicker({ dateFormat: 'dd-mm-yy' }).val();
                // alert(h);
            });
        });
    </script>
@endsection