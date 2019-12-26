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
							<tr style="color: #fff;background: #3c8dbc;">
								<td colspan="8">{{'Highest Level '.$leaderboard->level}}</td>
							</tr>
						    <tr>
						      <th>{{tr('Index')}}</th>
						      <th>{{tr('Full Name')}}</th>
						      <th>{{tr('Email')}}</th>
						      <th>{{tr('Mobile')}}</th>
							  <th>{{tr('Quiz Level')}}</th>
							  <th>{{tr('Total Earned')}}</th>
							  <th>{{tr('Active')}}</th>
						      <th>{{tr('Action')}}</th>
						    </tr>
						</thead>
						<tbody></tbody>
					</table>
            </div>
          </div>
        </div>
    </div>

@endsection