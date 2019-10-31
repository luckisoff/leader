@extends('layouts.admin')

@section('title', 'Add New Contestant')

@section('content-header', 'Add New Contestant')

@section('styles')
{{--    <link rel="stylesheet" href="{{asset('admin-css/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">--}}
    <link rel="stylesheet" href="{{asset('admin-css/plugins/datepicker/datepicker3.css')}}">
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('audition.view-audition')}}"><i class="fa fa-users"></i>Show All Audition Constestant</a></li>
    <li class="active"><i class="fa fa-plus"></i> Add New Audition User</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" id="" action="{{route('audition.add-audition')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <div class="col-md-6">
                            <input type="hidden" name="crsf" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="" class="">Contestant Name <span style="color:red;">*</span></label>
                                <input type="text" required value="{{old('name')}}"  class="form-control" id="" name="name" placeholder="Enter Contestant Name">
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
                                    <option value="male"   @if(   old('gender')  == "male") selected @endif> Male</option>
                                    <option value="female" @if( old('gender') == "female") selected @endif>Female</option>
                                    <option value="others" @if( old('gender') == "others") selected @endif>Others</option>
                                </select>
                                @if($errors->has('gender'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('gender') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="" class="">Address<span style="color:red;">*</span></label>
                                <input type="text" required  class="form-control" id="" value="{{old('address')}}" name="address" placeholder="Enter  Address">
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
                                <input type="number" required class="form-control" id="" name="number" value="{{ old('number') }}"  placeholder="Enter Contact Number " >
                                @if($errors->has('number'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('number') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="" class="">Email <span style="color:red;">*</span></label>
                                <input type="email"  class="form-control" id="" name="email" value="{{  old('email') }}" placeholder="Enter Email Address">
                                @if($errors->has('email'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('email') }}
                                  </span>
                                @endif
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger"><i class="fa fa-trash"></i> Reset</button>
                        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check-circle"></i> Save </button>
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
            $(function () {
                $('#datepicker').datepicker({
                    dateFormat: 'yyyy-mm-dd'
                });

            });
        });
    </script>
@endsection