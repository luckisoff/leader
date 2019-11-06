@extends('layouts.admin')

@section('title', 'Add App')

@section('content-header', 'Add App')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('app')}}"><i class="fa fa-shopping-cart"></i> App</a></li>
    <li class="active"><i class="fa fa-plus"></i>Add App</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" id="sponser-add" action="{{route('storeapp')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="title" class="">App Name:</label>
                                <input type="text" required class="form-control" id="" name="name" placeholder="Enter App Name">
                                @if($errors->has('name'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('name') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description" class="">Status:</label><br>
                                <select name="status" id="status">
                                    <option value="1">On</option>
                                    <option value="0">Off</option>
                                </select>
                                
                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger"><i class="fa fa-trash"></i> Reset</button>
                        <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-plus"></i> Add</button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection