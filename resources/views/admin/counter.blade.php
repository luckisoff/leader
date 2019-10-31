@extends('layouts.admin')

@section('title', 'Counters')

@section('content-header', 'Counters')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li class="active"><i class="fa fa-suitcase"></i> {{('Counter')}}</li>
@endsection

@section('content')

	@include('notification.notify')

	<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">

            	@if(count($counters) > 0)

	              	<table id="example1" class="table table-bordered table-striped">

						<thead>
						    <tr>
							  <th>{{tr('Counter Name')}}</th>
							  <th>{{tr('Counter Date')}}</th>
							  <th>{{tr('Counter Time')}}</th>
							  <th>{{tr('Counter Status')}}</th>
						      <th>{{tr('Action')}}</th>
						    </tr>
						</thead>

						<tbody>
							@foreach($counters as $i => $counter)

							    <tr>
							      	<td>{{$counter->name}}</td>
							      	<td>{{$counter->years}}</td>
									<td>{{$counter->months}}</td>
									<td>
									    @if((\Carbon\Carbon::parse($counter->years.' '.$counter->months))<=(\Carbon\Carbon::now()))
									        <span class="label label-danger">{{'Expired'}}</span>
									    @else
									        <span class="label label-success">{{'Active'}}</span>
									    @endif
									</td>
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
                                                       
                                                            <a role="menuitem" tabindex="-1" href="{{route('editcounter' , array('id' => $counter->id))}}">{{tr('edit')}}</a>
                                                        
                                                    </li>
								                  	<li role="presentation">
								                  			<a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?')" href="{{route('deletecounter' , array('id' => $counter->id))}}">{{tr('delete')}}</a>
								                  		
								                  	</li>
								                </ul>
              								</li>
            							</ul>
							      </td>
							    </tr>
							@endforeach
						</tbody>
					</table>
				@else
					<h3 class="no-result">No results found</h3>
				@endif
            </div>
          </div>
        </div>
    </div>

@endsection
