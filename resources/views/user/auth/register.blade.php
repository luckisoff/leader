@extends('layouts.user.focused')

@section('content')

<!-- Sing in  Form -->
<section class="sign-in">
  <div class="signin-content">
    <div class="signin-image">
        <figure><img src="{{Setting::get('site_logo' , asset('logo.png'))}}" alt="the leader" class="img-responsive"></figure>
        <a href="{{ route('user.login.form') }}" class="signup-image-link">I am already member</a>
    </div>

    <div class="signin-form">
        <h2 class="form-title">Leader Sign up</h2>
    
       <form role="form" method="POST" action="{{ url('/register') }}" class="register-form" id="login-form">
           
           {!! csrf_field() !!}
           @foreach ($errors->all() as $error)
               <span class="form-error">{{ $error }}</span>
           @endforeach

           <div class="form-group">
               <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
               <input type="text" name="name" required id="name" placeholder="Enter your full name"/>
           </div>

           <div class="form-group">
               <label for="email"><i class="zmdi zmdi-email material-icons-name"></i></label>
               <input type="email" name="email" required id="email" placeholder="Enter your email address"/>
           </div>

           <div class="form-group">
               <label for="pwd"><i class="zmdi zmdi-key material-icons-name"></i></label>
               <input type="password" name="password" required id="pwd" placeholder="Enter a password"/>
           </div>

           <div class="form-group">
               <label for="pwd2"><i class="zmdi zmdi-key material-icons-name"></i></label>
               <input type="password" name="password_confirmation" required id="pwd2" placeholder="Confirm your password"/>
           </div>

           <div class="form-group form-button">
               <input type="submit" class="form-submit" value="Sign Up"/>
           </div>
       </form>
       <div class="social-login">
            <span class="social-label">Or register with</span>
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
