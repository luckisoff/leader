@extends('layouts.admin')

@section('title', tr('New Admin'))

@section('content-header', tr('New Admin'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('admin.users')}}"><i class="fa fa-user"></i> {{tr('users')}}</a></li>
    <li class="active">{{tr('add_user')}}</li>
@endsection

@section('content')

@include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" action="{{route('admin.new.register')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <div class="form-group">
                            <label for="email" class="col-sm-1 control-label">{{tr('Email')}}</label>
                            <div class="col-sm-10">
                                <input type="email" required class="form-control" id="email" name="email" placeholder="{{tr('email')}}">
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-1 control-label">{{tr('Name')}}</label>

                            <div class="col-sm-10">
                                <input type="text" required name="name" class="form-control" id="Name" placeholder="{{tr('name')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-1 control-label">{{tr('Password')}}</label>
                            <div class="col-sm-10">
                                <input type="password" required name="password" class="form-control" id="password" placeholder="{{tr('password')}}">
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="col-sm-1 control-label">{{tr('Confirm')}}</label>
                            <div class="col-sm-10">
                                <input type="password" required name="password_confirmation" class="form-control" id="password_confirmation" placeholder="{{tr('confirm password')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dashboard" class="col-sm-1 control-label">{{tr('Dashboard Access')}}</label>
                            <div class="col-sm-10">
                                <select name="is_activated" id="is_activated" class="">
                                    <option value="0">Denie Access</option>
                                    <option value="1">Give Full Access</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger">{{tr('cancel')}}</button>
                        <button type="submit" class="btn btn-success pull-right">{{tr('submit')}}</button>
                    </div>
                </form>
            
            </div>

        </div>

    </div>

@endsection