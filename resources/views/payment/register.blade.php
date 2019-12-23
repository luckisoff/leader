@extends('layouts.user.focused')

@section('content')
 @if(!$audition)
  <section class="sign-in">
    <div class="signin-content">
      <div class="signin-image">
        <figure><img src="{{ asset('images/ravi-lamichhane.png')}}" alt="leader banner image"></figure>
      </div>
      <div class="signin-form">
         <h2 class="form-title">Leader Registration</h2>
         <form method="POST" action="{{ url('web/audition/register') }}" class="register-form" id="register-form">
           {!! csrf_field() !!}

           @foreach ($errors->all() as $error)
              <span class="form-error">{{ $error }}</span>
           @endforeach

           <div class="form-group">
              <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
              <input type="text" name="name" required id="name" id="name" value="{{$user?$user->name:''}}" placeholder="Your Name"/>
           </div>

           <div class="form-group">
              <label for="phone"><i class="zmdi zmdi-smartphone-info material-icons-name"></i></label>
              <input type="tel" name="phone" required id="phone" value="{{$user?$user->phone:''}}" title="Mobile number"/>
              <input type="hidden" name="country_code" id="country_code" value="">
           </div>

           <div class="form-group">
               <label for="location"><i class="zmdi zmdi-male-female material-icons-name"></i></label>
               <select name="gender" id="gender">
                   <option value="">-- select --</option>
                   <option value="Male">Male</option>
                   <option value="Female">Female</option>
                   <option value="Other">Other</option>
               </select>
           </div>

           <div class="form-group">
               <label for="email"><i class="zmdi zmdi-email material-icons-name"></i></label>
               <input type="email" name="email" required id="email" value="{{$user?$user->email:''}}">
           </div>

           <div class="form-group">
               <label for="address"><i class="zmdi zmdi-google-maps material-icons-name"></i></label>
               <select name="address" id="address">
                   <option value="">-- Audition Location --</option>
                   <option value="Kathmandu">Kathmandu</option>
                   <option value="Pokhara">Pokhara</option>
                   <option value="Chitwan">Chitwan</option>
                   <option value="Dhangadhi">Dhangadhi</option>
                   <option value="Butwal">Butwal</option>
                   <option value="Nepalgunj">Nepalgunj</option>
                   <option value="Biratnagar">Biratnagar</option>
                   <option value="USA">United States of America</option>
                   <option value="UK">United Kingdom</option>
                   <option value="Saudi Arabia">Saudi Arabia</option>
                   <option value="UAE">United Arab Emirates</option>
                   <option value="Malaysia">Malaysia</option>
                   <option value="South Korea">South Korea</option>
                   <option value="Australia">Australia</option>
               </select>
           </div>

           <div class="form-group">
              <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
              <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in <a href="{{ url('page/terms') }}" class="term-service">Terms of service</a></label>
          </div>
          <div class="form-group form-button">
              <input type="submit" name="signup" id="signup" class="form-submit" value="Register" disabled="true" />
          </div>
        </form>
      </div>
    </div>  
  </section>
 @elseif($audition->payment_status == 1)
  <section class="dashboard registration">
    <div class="row">
      <h3>Hello, {{ $audition->name }}</h3>

      <p>
        Congratulations! You have successfully registered. Your registration code is <strong>{{ $audition->registration_code }}</strong> . We will shortly contact you for the re-conformation.
      </p>
      <p>
        If you have any confusion, please contact us at -
      </p>
      <ul>
        <li><i class="fa fa-phone"></i>&nbsp;&nbsp;<strong>01-0692904</strong></li>
        <li><i class="fa fa-envelope"></i>&nbsp;&nbsp;<strong><a href="mailto:hello@theleadernepal.com?Subject=Leader%20Query" target="_top">hello@theleadernepal.com</a></strong></li>
        <li><i class="fa fa-facebook-f"></i>&nbsp;&nbsp;<strong>
          <a href="https://www.facebook.com/theleadernepal" target="_new">www.facebook.com/theleadernepal</a>
        </strong></li>

      </ul>

    </div>
  </section>
  <script src="https://use.fontawesome.com/07b0ce5d10.js"></script>

  @endif
@endsection
