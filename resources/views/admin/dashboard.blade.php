@extends('layouts.admin')

@section('title', tr('dashboard'))

@section('content-header', tr('dashboard'))

@section('breadcrumb')
    <li class="active"><i class="fa fa-dashboard"></i> {{tr('dashboard')}}</a></li>
@endsection

<style type="text/css">
  .center-card{
    	width: 30% !important;
	}
  .small-box .icon {
    top: 0px !important;
  }
</style>

@section('content')
    
	<div class="row">

		<!-- Total Users -->

		<div class="col-lg-3 col-xs-6">

          	<div class="small-box bg-green">
            	<div class="inner">
              		<h3>{{$user_count}}</h3>
              		<p>{{tr('total_users')}}</p>
            	</div>
            	
            	<div class="icon">
              		<i class="fa fa-user"></i>
            	</div>

            	<a href="{{route('admin.users')}}" class="small-box-footer">
              		{{tr('more_info')}}
              		<i class="fa fa-arrow-circle-right"></i>
            	</a>
          	</div>
        </div>

		<!-- Total Moderators -->

          <div class="col-lg-3 col-xs-6">

            <div class="small-box label-primary">
                <div class="inner">
                    <h3>{{$categories}}</h3>
                    <p>{{tr('categories')}}</p>
                </div>
                
                <div class="icon">
                    <i class="fa fa-suitcase"></i>
                </div>

                <a href="{{route('admin.categories')}}" class="small-box-footer">
                    {{tr('more_info')}}
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        
        </div>


        

        <div class="col-lg-3 col-xs-6">

          	<div class="small-box bg-yellow">
            	<div class="inner">
              		<h3>{{$video_count}}</h3>
              		<p>{{tr('today_videos')}}</p>
            	</div>
            	
            	<div class="icon">
              		<i class="fa fa-video-camera"></i>
            	</div>

            	<a href="{{route('admin.videos')}}" class="small-box-footer">
              		{{tr('more_info')}}
              		<i class="fa fa-arrow-circle-right"></i>
            	</a>
          	</div>
        
        </div>


        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-orange">
              <div class="inner">
                    <h3>{{'Rs. '.number_format($total_earned,0)}}</h3>
                    <p>{!!tr('People Earned').' <a style="color:#fff;text-decoration: underline;" href="'.route("view-claim").'">(Claims '.$total_claims.')</a>'!!}</p>
              </div>
              
              <div class="icon">
                    <i class="fa fa-dollar"></i>
              </div>
              <a href="{{route('admin.users')}}" class="small-box-footer">
                {{tr('more_info')}}
                <i class="fa fa-arrow-circle-right"></i>
          </a>
            </div>
            
      </div>

      
	</div>



    <div class="row">
        @if(count($recent_users) > 0)

        <div class="col-md-6">
              <!-- USERS LIST -->
            <div class="box box-danger">

                <div class="box-header with-border">
                    <h3 class="box-title">{{tr('latest_users')}}</h3>

                    <div class="box-tools pull-right">
                        <!-- <span class="label label-danger">8 New Members</span> -->
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                        @foreach($recent_users as $user)

                            <li>
                                <img style="width:60px;height:60px" src="@if($user->picture) {{$user->picture}} @else {{asset('placeholder.png')}} @endif" alt="User Image">
                                <a class="users-list-name" href="{{route('admin.view.user' , $user->id)}}">{{$user->name}}</a>
                                <span class="users-list-date">{{$user->updated_at->diffForHumans()}}</span>
                            </li>

                        @endforeach
                    </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->

                <div class="box-footer text-center">
                    <a href="{{route('admin.users')}}" class="uppercase">{{tr('view_all')}}</a>
                </div>

                <!-- /.box-footer -->
            </div>

              <!--/.box -->
        </div>

        @endif

        @if(count($recent_videos) > 0)
            <div class="col-md-6">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">{{tr('recent_videos')}}</h3>

                        <div class="box-tools pull-right">

                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>

                            <button type="button" class="btn btn-box-tool" data-widget="remove">
                                <i class="fa fa-times"></i>
                            </button>
                      </div>

                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <ul class="products-list product-list-in-box">
                            @foreach($recent_videos as $v => $video)

                                @if($v < 5)
                                    <li class="item">
                                        <div class="product-img">
                                            <img src="{{$video->default_image}}" alt="Product Image">
                                        </div>
                                        <div class="product-info">
                                            <a href="{{route('admin.view.video' , array('id' => $video->admin_video_id))}}" class="product-title">{{substr($video->title, 0,50)}}
                                                <span class="label label-warning pull-right">{{$video->duration}}</span>
                                            </a>
                                            <span class="product-description">
                                              {{substr($video->description , 0 , 75)}}
                                            </span>
                                      </div>
                                    </li>

                                @endif
                            @endforeach
                            <!-- /.item -->
                        </ul>
                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                        <a href="{{route('admin.videos')}}" class="uppercase">{{tr('view_all')}}</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        @endif

        @if(count($winners) > 0)
        <div class="col-md-6">
            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">{{tr('Live Quiz Winner')}}</h3>

                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>

                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                  </div>

                </div>

                <!-- /.box-header -->
                <div class="box-body">

                    <ul class="products-list product-list-in-box">
                        @foreach($winners as $v => $winner)

                            @if($v < 5)
                                <li class="item">
                                    <div class="product-img">
                                        <img src="{{$winner->user->picture}}" alt="Product Image">
                                    </div>
                                    <div class="product-info">
                                        <a href="#" class="product-title">{{$winner->user->name}}
                                            <span class="label label-warning pull-right">{{$winner->created_at->format('d M Y')}}</span>
                                        </a>
                                  </div>
                                </li>

                            @endif
                        @endforeach
                        <!-- /.item -->
                    </ul>
                </div>

                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="{{route('admin.videos')}}" class="uppercase">{{tr('view_all')}}</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    @endif

       
        {{-- <div class="col-md-6">
            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">{{tr('Apps')}} </span></h3>

                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-plus"> Add</i>
                        </button>

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>


                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                  </div>

                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="products-list product-list-in-box" id="app">
                        @foreach($apps as $v => $app)

                            @if($v < 5)
                                <li class="item">
                                    
                                </li>

                            @endif
                        @endforeach
                        <!-- /.item -->
                    </ul>
                </div>

                <!-- /.box-body -->
                <!-- /.box-footer -->
            </div>
        </div> --}}
            {{-- <div class="col-lg-9">
                <canvas id="myChart" width="400" height="200" border="1"></canvas>
            </div> --}}
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLabel">New App</h4>
                </div>
                <div class="modal-body">
                  <form id="app" method="POST" action="javascript:void(0)">
                        {{ csrf_field() }}
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">App Name:</label>
                      <input type="text" name="name" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label><br>
                        <select name="status" id="status">
                            <option value="1">On</option>
                            <option value="0">Off</option>
                        </select>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Add</button>
                </div>
              </div>
            </div>
          </div>

          <script>
              window.onload = function(){
                jQuery(document).ready(function() {
                jQuery(".btn-primary").click(function(e){
                    e.preventDefault();
        
        
                    var _token = jQuery("input[name='_token']").val();
                    var name = jQuery("input[name='name']").val();
                    var status = jQuery("#status").val();
        
        
                    jQuery.ajax({
                        url: 'http://localhost/leader/admin/app',
                        type:'POST',
                        data: {_token:_token, name:name,status:status},
                        success: function(response) {
                            $.each(this, function(k, v) {
                                $("#app").append(response.name).innerHtml;
                            });
                        }
                    });
        
        
                }); 
            });
              };  

            
        
        
        </script>
    
@endsection

