@extends('layouts.user.focused')

@section('content')

    <div class="login-box">
        {{-- <h4>{{tr('Login')}}</h4> --}}
        <div class="text-center">
            <a href="{{route('user.dashboard')}}"><img class="login-logo" src="{{Setting::get('site_logo' , asset('logo.png'))}}"></a>
        </div>

        <form role="form" method="POST" action="{{ url('/login') }}">
            
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" name="email" required class="form-control" id="email">
                @if($errors->has('email'))
                    <span class="form-error"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" name="password" required class="form-control" id="pwd">
                <span class="form-error">
                    @if ($errors->has('password'))
                        <strong>{{ $errors->first('password') }}</strong>
                    @endif
                </span>
            </div> 

          <button type="submit" class="btn btn-default">{{tr('Login')}}</button>
          <div class="social-login text-center">
            <h5>Or</h5>
                <a href="{{URL::to('/').'/social/facebook'}}"><span class="fb btn btn-large">Facebook</span></a>
                <a href="{{URL::to('/').'/social/google'}}"><span class="gl btn btn-large">Google</span></a>
            </div>
        </form>     
        
        
        
        <p class="help"><a href="{{route('user.register.form')}}">{{tr('Register')}}</a></p>
        <p class="help"><a href="{{ url('/password/reset') }}">{{tr('ForgetPassword?')}}</a></p>
        {{-- <p class="help"><a href="{{ url('/social/facebook') }}">{{tr('Facebook Login')}}</a></p> --}}
    </div>

@endsection
