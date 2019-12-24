<div class="navholder">
	<div class="container">
		<nav class="navbar navbar-default">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#">
		        <img src="{{ asset('images/logo.png')}}" class="img-responsive" width="50">
		      </a>
		    </div>
		    <div id="navbar" class="navbar-collapse collapse">
		      <ul class="nav navbar-nav navbar-right">
		        	@if(Auth::check())
								<li><a href="{{ route('web-leader-dashboard') }}">Dashboard</a></li>
								<li><a href="{{route('web-leader-register')}}">{{tr('Leader Registration')}}</a></li>
		            <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		              	@if(Auth::check()) {{Auth::user()->name}} @else User @endif <span class="caret"></span>
		          	</a>
		              <ul class="dropdown-menu">
						{{-- <li>
							<a href="{{route('user.delete.account')}}" @if(Auth::user()->login_by != 'manual') onclick="return confirm('Are you sure? . Once you deleted account, you will lose your history and wishlist details.')" @endif>
                        {{tr('Delete Account?')}}
                    		</a>
                		</li> --}}
              			@if(Auth::user()->login_by == 'manual')
											<li><a href="{{route('user.update.password-form')}}">{{tr('Change Password')}}</a></li>
										@endif
										<li><a href="{{route('user.logout')}}">{{tr('Logout')}}</a></li>
		              </ul>
		            </li>
		          @else
						<li><a href="{{ route('user.login.form') }}">Login</a></li>
						<li><a href="{{route('user.register.form')}}">Register</a></li>

					@endif
	        </ul>
	    	</div><!--/.nav-collapse -->
		</nav>
	</div>
</div>



