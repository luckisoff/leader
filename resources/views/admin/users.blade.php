@extends('layouts.admin')

@section('title', tr('users'))

@section('content-header', tr('users'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li class="active"><i class="fa fa-user"></i> {{tr('users')}}</li>
@endsection

@section('content')

	@include('notification.notify')

	<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">

	              	<table id="user-table" class="table table-bordered table-striped">
						<thead>
						    <tr>
						      <th>{{tr('id')}}</th>
						      <th>{{tr('username')}}</th>
						      <th>{{tr('email')}}</th>
						      <th>{{tr('mobile')}}</th>
							  <th>{{tr('quiz level')}}</th>
							  <th>{{tr('Total Earned')}}</th>
						      <th>{{tr('action')}}</th>
						    </tr>
						</thead>
						<tbody></tbody>
					</table>
            </div>
          </div>
        </div>
    </div>

@endsection