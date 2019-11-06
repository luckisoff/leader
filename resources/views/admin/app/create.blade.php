@extends('layouts.admin')

@section('title', $app?'Edit App':'Add App')

@section('content-header', $app?'Edit App':'Add App')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('app')}}"><i class="fa fa-shopping-cart"></i> App</a></li>
<li class="active"><i class="fa fa-plus"></i>{{$app?'Edit App':'Add App'}}</li>
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
                            @if($app)
                            <input type="id" name="id" value="{{$app->id}}" hidden>
                            @endif
                            <div class="form-group">
                                <label for="title" class="">App Name:</label>
                            <input type="text" required class="form-control" id="" name="name" placeholder="Enter App Name" value="{{$app?$app->name:''}}">
                                @if($errors->has('name'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('name') }}
                                  </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description" class="">Status:</label><br>
                                <select name="status" id="status">
                                    <option value="1" {{$app->status==1?'selected':''}}>On</option>
                                    <option value="0" {{$app->status==0?'selected':''}}>Off</option>
                                </select>
                                
                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger"><i class="fa fa-trash"></i> Reset</button>
                    <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-plus"></i> {{$app?'Update':'Add'}}</button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection