@extends('layouts.user.focused')

@section('content')

<!-- Sing in  Form -->
<section class="sign-in">
  <div class="signin-content">
    <div class="signin-image">
        <figure><img src="{{Setting::get('site_logo' , asset('logo.png'))}}" alt="the leader" class="img-responsive"></figure>
        <a href="{{route('user.register.form')}}" class="signup-image-link">Create an account</a>
    </div>

    <div class="signin-form">
        <h2 class="form-title">Sign in</h2>
        <form role="form" method="POST" action="{{ url('/login') }}" class="register-form" id="login-form">
            {!! csrf_field() !!}

            @foreach ($errors->all() as $error)
                <span class="form-error">{{ $error }}</span>
            @endforeach
            <div class="form-group">
                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                <input type="email" name="email" required id="email" placeholder="email id"/>
               
            </div>
            <div class="form-group">
                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                <input type="password" name="password" required id="password" placeholder="password"/>
            </div>
            <a href="{{ url('/password/reset') }}" class="signup-image-link forgot-password">Forget Password?</a>

            <!-- <div class="form-group">
                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
            </div> -->
            <div class="form-group form-button">
                <input type="submit" class="form-submit" value="Log in"/>
            </div>
        </form>

        <div class="social-login">
            <span class="social-label">Or login with</span>
            <ul class="socials">
                <li><a href="{{URL::to('/').'/social/facebook'}}"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                <!-- <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li> -->
                <li><a href="{{URL::to('/').'/social/google'}}"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
            </ul>
        </div>
    </div>
  </div>
</section>

@endsection



