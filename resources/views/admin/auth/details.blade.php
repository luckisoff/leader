@extends('layouts.admin')

@section('title', tr('Auditions'))

@section('content-header', tr('Leader Audition Users'))

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

            	@if(count($auditions) > 0)

	              	<table id="example1" class="table table-bordered table-striped">

						<thead>
						    <tr>
						      <th>{{tr('Id')}}</th>
						      <th>{{tr('Name')}}</th>
                              <th>{{tr('Email')}}</th>
                              <th>{{tr('Status')}}</th>
                              <th>{{tr('Paid Through')}}</th>
                              <th>{{tr('Reg. Code')}}</th>
						    </tr>
						</thead>

						<tbody>
							@foreach($auditions as $i => $audition)
							    <tr>
							      	<td>{{$i+1}}</td>
							      	<td>{{$audition->name}}</td>
							      	<td>{{$audition->email}}</td>
                                    <td>{{$audition->payment_status==1?'Paid':'Unpaid'}}</td>
                                    <td>{{$audition->payment_type}}</td>
                                    <td>{{$audition->registration_code}}</td>

                                </tr>
							@endforeach
						</tbody>
					</table>
				@else
					<h3 class="no-result">{{tr('no_user_found')}}</h3>
				@endif
            </div>
          </div>
        </div>
    </div>

@endsection
