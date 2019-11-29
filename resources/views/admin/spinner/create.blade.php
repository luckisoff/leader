@extends('layouts.admin')

@section('title', 'Add Spinner Landmark')

@section('content-header','Add Spinner Landmark')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('app')}}"><i class="fa fa-shopping-cart"></i> Landmark</a></li>
<li class="active"><i class="fa fa-plus"></i>{{'Add Landmark'}}</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" id="sponser-add" action="{{route('storelandmark')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title" class="">Ladmark Point</label>
                                <input type="number" required class="form-control" id="" name="point" placeholder="Enter Landmark Point">
                                @if($errors->has('point'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('point') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="title" class="">Ladmark Price</label>
                                <input type="number" class="form-control" id="" name="price" placeholder="Enter Landmark Price">
                                @if($errors->has('price'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('price') }}
                                  </span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger"><i class="fa fa-trash"></i> Reset</button>
                    <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-plus"></i> {{'Add'}}</button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection