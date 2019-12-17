@extends('layouts.admin')

@section('title', tr('Admins'))

@section('content-header', tr('Admin Users'))

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

            	@if(count($users) > 0)

	              	<table id="example1" class="table table-bordered table-striped">

						<thead>
						    <tr>
						      <th>{{tr('Id')}}</th>
						      <th>{{tr('Name')}}</th>
                              <th>{{tr('Email')}}</th>
                              <th>Dashboard Access</th>
						      <th>{{tr('action')}}</th>
						    </tr>
						</thead>

						<tbody>
							@foreach($users as $i => $user)
                                @if(Auth::guard('admin')->user()!=$user)
							    <tr>
							      	<td>{{$i+1}}</td>
							      	<td>{{$user->name}}</td>
							      	<td>{{$user->email}}</td>
							        <td>{{$user->is_activated?'Full':'None'}}</td>
							      	<td>
							      		
            							<ul class="admin-action btn btn-default">
											@if($i == 0 || $i == 1)
            									<li class="dropdown">
            								@else
            									<li class="dropup">
            								@endif	
								                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
								                  {{tr('action')}} <span class="caret"></span>
								                </a>
								                <ul class="dropdown-menu">
								                  	<li role="presentation">

								                  	 @if(Setting::get('admin_delete_control'))
								                  	 	<a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>
								                  	 @else

								                  	 	<a role="menuitem" tabindex="-1"
								                  			onclick="return confirm('Are you sure?');" href="{{route('admin.delete.admin', $user)}}">{{tr('delete')}}
														</a>
														  
														<a role="menuitem" tabindex="-1"
														  href="{{route('admin.details.admin', $user)}}">{{tr('details')}}
														</a>


								                  	 @endif

								                  	</li>

								                </ul>
              								</li>
            							
            							</ul>

							      	</td>

                                </tr>
                                @endif
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
