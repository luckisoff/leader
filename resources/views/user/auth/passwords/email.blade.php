@extends('layouts.user.focused')

@section('content')

<!-- Sing in  Form -->
<section class="sign-in">
  <div class="signin-content">
    <div class="signin-image">
        <figure><img src="{{Setting::get('site_logo' , asset('logo.png'))}}" alt="the leader" class="img-responsive"></figure>
    </div>
    <div class="signin-form">
      <h2 class="form-title">Forgot Password</h2>
      <form role="form" method="POST" action="{{ url('/password/email') }}" class="register-form" id="login-form">
        {!! csrf_field() !!}
        @foreach ($errors->all() as $error)
          <span class="form-error">{{ $error }}</span>
        @endforeach

        <div class="form-group">
           <label for="email"><i class="zmdi zmdi-email material-icons-name"></i></label>
           <input type="text" name="email" required id="email" placeholder="Enter your email id"/>
        </div>

        <div class="form-group form-button">
          <input type="submit" class="form-submit" value="Reset Password"/>
        </div>
      </form>
      <div class="social-login">
          <ul class="socials">
              <li><a href="{{ route('user.login.form') }}" class="signup-image-link">Sign in to your account</a></li>
              <li>|</li>
              <li><a href="{{route('user.register.form')}}" class="signup-image-link">Register your account</a></li>
          </ul>
      </div>
    </div>
  </div>
</section>

@endsection