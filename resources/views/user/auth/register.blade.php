@extends('layouts.user.focused')

@section('content')

<div class="login-box">
    {{-- <h4>{{tr('register')}}</h4> --}}
    <div class="text-center">
        <a href="{{route('user.dashboard')}}"><img class="login-logo" src="{{Setting::get('site_logo' , asset('logo.png'))}}"></a>
    </div>
    
    <form role="form" method="POST" action="{{ url('/register') }}">
        
      <div class="form-group">
        {!! csrf_field() !!}
        @if($errors->has('email') || $errors->has('name') || $errors->has('password_confirmation') ||$errors->has('password'))
            <div data-abide-error="" class="alert callout">
                <p>
                    <i class="fa fa-exclamation-triangle"></i> 
                    <strong> 
                        @if($errors->has('email')) 
                            {{ $errors->first('email') }}
                        @endif

                        @if($errors->has('name')) 
                            {{ $errors->first('name') }}
                        @endif

                        @if($errors->has('password')) 
                            {{$errors->first('password') }}
                        @endif

                        @if($errors->has('password_confirmation'))
                            {{ $errors->first('password_confirmation') }}
                        @endif

                    </strong>
                </p>
            </div>
        @endif
        <label for="name">{{tr('Name')}}</label>
        <input type="text" name="name" required class="form-control" id="name" placeholder="Enter your full name">
      </div>
      <div class="form-group">
        <label for="email">{{tr('Email')}}</label>
        <input type="email" name="email" required class="form-control" id="email" placeholder="Enter your email address">
      </div>
      <div class="form-group">
        <label for="pwd">{{tr('Password')}}</label>
        <input type="password" name="password" required class="form-control" id="pwd" placeholder="Enter a password">
      </div>  
      <div class="form-group">
        <label for="pwd">{{tr('Confirm Password')}}</label>
        <input type="password" name="password_confirmation" required class="form-control" id="pwd" placeholder="Confirm your password">
      </div>                  
      <button type="submit" class="btn btn-default">{{tr('Sign Up')}}</button>
    </form>                
    <p class="help"><a href="{{ route('user.login.form') }}">{{tr('Login')}}</a></p>         
</div>

@endsection
