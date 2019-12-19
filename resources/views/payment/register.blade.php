@extends('layouts.user.focused')

@section('content')
    <div class="login-box">
      <section class="sign-in">
       <div class="container">
         @if(!$audition)
        
         <div class="signin-content">
           <div class="signin-image">
             <figure><img src="{{ asset('images/ravi-lamichhane.png')}}" alt="leader banner image"></figure>
             <a href="#" class="signup-image-link">I am already member</a>
             <div class="social-login">
               <span class="social-label">Or Register with</span>
               <ul class="socials">
                  <li><a href="{{URL::to('/').'/social/facebook'}}"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                  <!-- <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li> -->
                  <li><a href="{{URL::to('/').'/social/google'}}"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
               </ul>
             </div>
           </div>
           <div class="signin-form">
             <h2 class="form-title">Sign up</h2>
             <form method="POST" action="{{ url('web/audition/register') }}" class="register-form" id="register-form">
               {!! csrf_field() !!}

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
                       <option value="">-- select --</option>
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
                  <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in <a href="{{ 'page/terms'}}" class="term-service">Terms of service</a></label>
              </div>
              <div class="form-group form-button">
                  <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
              </div>
            </form>   
         </div>  
         </div>           
         
         @else
         @if($audition->payment_status==1)
            <h4 style="margin-bottom:0px">{{tr('Registration Detail')}}</h4><br>
            <div class="row">
                    <div class="col-xs-12" style="color:#000">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-xs-3">
                                    <img style="border-radius: 50%;width: 65px;height: 65px;margin: 38px 15px;border: 2px solid #000;" src="{{$audition->user->picture}}" alt="{{$audition->name.'-image'}}" class="img-responsive" />
                                </div>
                                <div class="col-xs-9">
                                    <h4 style="text-align:left"><i class="fa fa-user"></i> {{$audition->name}}</h4>
                                   
                                    <p>
                                        <table style="width: 225px;height: 152px;" class="table table-bordered">
                                            <tr>
                                                <td style="text-align: center"><i class="fa fa-map-marker"></i> </td>
                                                <td>{{$audition->address?$audition->address:'Not Confirmed'}}</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center"><i class="fa fa-envelope"></i></td>
                                                <td>{{$audition->email}}</td></tr>
                                            <tr>
                                                <td style="text-align: center"><i class="fa fa-{{$audition->gender=='Female'?'female':'male'}}"></i></td>
                                                <td>{{$audition->gender}}</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center"><i class="fa fa-money"></i></td>
                                                <td>{{$audition->payment_status?'Paid':'Error...!'}}</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center"><i class="fa fa-ticket"></i></td>
                                                <td>{{$audition->registration_code}}</td>
                                            </tr>
                                        </table>                                         
                                    </p>
                                    @if(session('message'))
                                        <h6 class="alert alert-success">{{session('message')}}</h6>
                                    @endif
                                    <!-- Split button -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @else
            <a href="{{route('web-leader-payment')}}" style="color:#ffffff"><h4 style="margin-bottom:0px">{{tr('Pay')}}</h4></a>
        @endif
    @endif 
    </div>
  </div>
</section>

@endsection
