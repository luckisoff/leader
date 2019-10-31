@extends('layouts.admin')

@section('title', $editCounter!=''?'Edit Counter':'Add New Counter')

@section('content-header', $editCounter!=''?'Edit Counter':'Add New Counter')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('banner.view-banner')}}"><i class="fa fa-bookmark"></i> Counter</a></li>
    <li class="active"><i class="fa fa-plus"></i> {{$editCounter!=''?'Edit Counter':'Add New Counter'}}</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-info">

                <div class="box-header">
                </div>

                <form class="form-horizontal" id= "Counter-add" action="{{route('storecounter',$editCounter!=''?$editCounter->id:'')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <div class="col-md-3">

								<div class="form-group">
										<label for="title" class="">Name <span style="color:red;">*</span></label>
									<input type="text" required class="form-control" id="name" name="name" value="{{$editCounter!=''?$editCounter->name:old('name')}}" placeholder="Enter Name" >
									
										@if($errors->has('name'))
										<span class="help-block" style="color:red;">
										  * {{ $errors->first('name') }}
									  </span>
									  @endif
									</div>

								
								
									
                               
                            

                            {{-- <div class="form-group">
                                <label for="years" class="">Years<span style="color:red;">*</span></label>
								<input type="number" required class="form-control" id="years" name="years" value="{{$editCounter!=''?$editCounter->years:old('years')}}" placeholder="Enter Years">
								@if($errors->has('years'))
                                    <span class="help-block" style="color:red;">
                                      * {{ $errors->first('years') }}
                                  </span>
                                @endif
							</div> --}}
						</div>

                        <div class="col-md-1"></div>

                        <div class="col-md-3">
								<div class="form-group">
										<label for="date" class="">Date<span style="color:red;">*</span></label>
										<input type="date" required class="form-control" id="date" name="date" value="{{$editCounter!=''?$editCounter->date:old('date')}}" placeholder="Enter Date">
										@if($errors->has('days'))
											<span class="help-block" style="color:red;">
											  * {{ $errors->first('days') }}
										  </span>
										@endif
								</div>
                        </div>
						<div class="col-md-1"></div>
                        <div class="col-md-3">

								{{-- <div class="form-group">
										<label for="days" class="">Days<span style="color:red;">*</span></label>
										<input type="number" required class="form-control" id="days" name="days" value="{{$editCounter!=''?$editCounter->days:old('days')}}" placeholder="Enter Days">
										@if($errors->has('days'))
											<span class="help-block" style="color:red;">
											  * {{ $errors->first('days') }}
										  </span>
										@endif
								</div> --}}
								
								
								<!--fjsdkfsl-->
								<div class="form-group">
										<label for="time" class="">Time<span style="color:red;">*</span></label>
										<input type="time" required class="form-control" id="time" name="time" step="1" value="{{$editCounter!=''?$editCounter->time:old('time')}}" placeholder="Enter time">
										@if($errors->has('days'))
										<span class="help-block" style="color:red;">
										  * {{ $errors->first('days') }}
									  		</span>
										@endif
								</div>
								<!--/flksdjkf-->

                        </div>
					</div>
					
                    <div class="box-footer">
						@if($editCounter=='')
						<button type="reset" class="btn btn-danger"><i class="fa fa-redo"></i>Reset</button>
						@endif
                        <button type="submit" class="btn btn-success pull-right"> {{$editCounter!=''?'Save':'Add'}} </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection
