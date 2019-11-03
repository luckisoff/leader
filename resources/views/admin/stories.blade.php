@extends('layouts.admin')

@section('title', 'Stories')

@section('content-header', 'Stories')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li class="active"><i class="fa fa-suitcase"></i> {{('Stories')}}</li>
@endsection

@section('content')

	@include('notification.notify')

	<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">

            	@if(count($stories) > 0)

	              	<table id="example1" class="table table-bordered table-striped">

						<thead>
						    <tr>
						      <th>{{tr('#')}}</th>
						      <th>{{tr('story name')}}</th>
						      <th>{{tr('picture')}}</th>
						      <th>{{tr('Category')}}</th>
						      <th>{{tr('Status')}}</th>
						      <th>{{tr('action')}}</th>
						    </tr>
						</thead>

						<tbody>
							@foreach($stories as $i => $story)

							    <tr>
							        <td>{{$i+1}}</td>
							      	<td>{{$story->name}}</td>
							      	<td>
	                                	<img style="height: 30px;" src="{{$story->picture}}">
	                            	</td>
	                            	<td>{{$story->category['name']}}</td>
	                            	<td>
	                            	    @if($story->updated_at->diffInHours(\Carbon\Carbon::now())>24)
	                            	        <span class="label label-success">Active</span>
	                            	    @else
	                            	        <span class="label label-danger">Expired</span>
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
                                                       
                                                            <a role="menuitem" tabindex="-1" href="{{route('admin.edit.story' , array('id' => $story->id))}}">{{tr('edit')}}</a>
                                                        
                                                    </li>
								                  	<li role="presentation">
								                  			<a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?')" href="{{route('admin.delete.story' , array('story_id' => $story->id))}}">{{tr('delete')}}</a>
								                  		
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
