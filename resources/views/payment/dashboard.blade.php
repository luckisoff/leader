@extends('layouts.user.focused')
@section('content')
   <section class="dashboard">
       <div class="row" >
          <div class="col-sm-3">
             <div class="circle-tile">
                 <a href="javascript:void(0)" title="Gundurk Quiz">
                     <div class="circle-tile-heading blue">
                         <i class="fa fa-trophy fa-fw fa-3x"></i>
                     </div>
                 </a>
                 <div class="circle-tile-content blue">
                     <div class="circle-tile-description text-faded">
                         Gundurk Quiz
                     </div>
                     <div class="circle-tile-number text-faded" data-toggle="tooltip" title="Levels Completed">
                         {{ $data['level'] ? $data['level'] : '0' }} Level
                     </div>
                     <a href="javascript:void(0)" class="circle-tile-footer" title="Gundurk Leaderboard">{{ $data['position'] ? '#'.$data['position'] : 'Not Available' }}</a>
                 </div>
             </div>
          </div>
          <div class="col-sm-3">
             <div class="circle-tile">
                 <a href="javascript:void(0)" title="Pending Redeem Amount">
                     <div class="circle-tile-heading orange">
                         <i class="fa fa-money fa-fw fa-3x"></i>
                     </div>
                 </a>
                 <div class="circle-tile-content orange">
                     <div class="circle-tile-description text-faded">
                         Redeem Amount
                     </div>
                     <div class="circle-tile-number text-faded" data-toggle="tooltip" title="Total Redeem Amount">
                         NPR {{ $data['pending_payment_claim'] ?: '0' }}
                     </div>
                     <a href="javascript:void(0)" class="circle-tile-footer" title="Redeem Amount Status">{{ $data['pending_payment_claim'] ? 'Pending Payment' : 'Not Available' }}</a>
                 </div>
             </div>
          </div>
          <div class="col-sm-3">
             <div class="circle-tile">
                 <a href="javascript:void(0)" title="Quiz Earning">
                     <div class="circle-tile-heading green">
                         <i class="fa fa-money fa-fw fa-3x"></i>
                     </div>
                 </a>
                 <div class="circle-tile-content green">
                     <div class="circle-tile-description text-faded">
                         Quiz Earning
                     </div>
                     <div class="circle-tile-number text-faded" data-toggle="tooltip" title="Amount Won">
                         NPR {{ $data['point'] ?: '0' }}
                     </div>
                     <a href="javascript:void(0)" class="circle-tile-footer" title="Total Withdrawn Amount">NPR {{ $data['payment_claim'] ?: '0' }}</a>
                 </div>
             </div>
          </div>
          
          <div class="col-sm-3">
             <div class="circle-tile">
                 <a href="javascript:void(0)" title="Gundruk Fanfani">
                     <div class="circle-tile-heading purple">
                         <i class="fa fa-life-ring fa-fw fa-3x"></i>
                     </div>
                 </a>
                 <div class="circle-tile-content purple">
                     <div class="circle-tile-description text-faded">
                         Fanfani
                     </div>
                     <div class="circle-tile-number text-faded" data-toggle="tooltip" title="Coins Collected">
                         {{ $data['spinnerPoints'] ? $data['spinnerPoints'] : '0' }} Points
                         <span id="sparklineD"></span>
                     </div>
                     <a href="javascript:void(0)" class="circle-tile-footer" title="Fanfani Leaderboard">{{ $data['spinnerPosition'] ? '#'.$data['spinnerPosition'] : 'Not Available' }}</a>
                 </div>
             </div>
          </div>
          
          <!-- <div class="col-sm-3">
             <div class="circle-tile">
                 <a href="javascript:void(0)">
                     <div class="circle-tile-heading orange">
                         <i class="fa fa-money fa-fw fa-3x"></i>
                     </div>
                 </a>
                 <div class="circle-tile-content orange">
                     <div class="circle-tile-description text-faded">
                         Quiz Earnings
                     </div>
                     <div class="circle-tile-number text-faded">
                         NPR 32,384
                     </div>
                     <a href="javascript:void(0)" class="circle-tile-footer">More Info</a>
                 </div>
             </div>
          </div> -->
       </div><!-- row END-->

       <div class="row userinfo">
         <div class="col-sm-12">
          <div class="jumbotron">
            <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-6 col-lg-3">
                  <img src="{{ $user->picture ?: 'https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg' }}" alt="{{ $user->name }}" title="{{ $user->name }}" class="img-circle img-responsive"> 
                </div>
                <div class="col-md-9 col-xs-12 col-sm-6 col-lg-9">
                  
                    <div style="border-bottom:1px solid black">
                      <h2>{{ $user->name }}</h2>
                    </div>
                    <hr>
                    
                    @if (\Session::has('success'))
                      <span class="alert alert-success" style="display:block;margin-bottom:10px">{!! \Session::get('success') !!}</span>
                    @endif

                    @if (\Session::has('error'))
                      <span class="alert alert-danger" style="display:block;margin-bottom:10px">{!! \Session::get('error') !!}</span>
                    @endif
                    
                    @if($audition)
                      <ul class="details">
                        <li>
                          <p>
                            <i class="fa fa-mobile fa-lg" style="width:50px;" data-toggle="tooltip" title="Mobile Number"></i>
                            {{ $audition->number}}
                            
                            @if($audition->payment_status)
                              <a href="javascript:void(0)" role="button" class="btn popovers" data-toggle="popover" data-trigger="focus" data-content="<a href='{{ url('web/audition/resend-sms-code')}}'>Resend Code</a>" data-original-title="Didn't got Registration Code?">
                                <i class="fa fa-info-circle fa-lg"></i>
                              </a>
                            @endif
                          </p>
                        </li>

                        <li>
                          <p>
                            <i class="fa fa-{{ (strtolower($audition->gender) !== 'male' ?  'female' : 'male')}} fa-lg" style="width:50px;" data-toggle="tooltip" title="Gender"></i>
                            {{ $audition->gender}}
                          </p>
                        </li>
                        <li>
                          <p>
                            <span class="glyphicon glyphicon-envelope one" style="width:50px;" data-toggle="tooltip" title="Email Address"></span>
                            {{ $audition->email}}
                            
                            @if($audition->payment_status)
                              <a href="javascript:void(0)" role="button" class="btn popovers" data-toggle="popover" data-trigger="focus" data-content="<a href='{{ url('web/audition/resend-email')}}'>Resend Code</a>" data-original-title="Didn't got Registration Code?">
                                <i class="fa fa-info-circle fa-lg"></i>
                              </a>
                            @endif
                          </p>
                        </li>
                        <li>
                          <p>
                            <span class="glyphicon glyphicon-map-marker one" style="width:50px;" data-toggle="tooltip" title="Audition Location"></span>
                            {{ $audition->address }}

                          </p>
                        </li>
                        <li>
                          <p>
                            <span class="glyphicon glyphicon-barcode one" style="width:50px;" data-toggle="tooltip" title="Registration Code"></span>
                            @if($audition->payment_status)
                              <span class="alert-success">{{ $audition->registration_code }}</span>
                            @else
                              <span class="label label-danger">Your payment hasn't been received for registration</span> 
                              <a class="btn btn-success btn-sm" href="{{ url('web/audition/payment') }}" data-toggle="tooltip" title="Pay Charge for Leader Registration">PAY NOW</a>
                            @endif
                          </p>
                        </li>
                    @else
                      <p>
                        <span class="label label-danger">You haven't registered for Leader</span> 
                        <a class="btn btn-success btn-sm" href="{{ url('web/audition/register') }}" data-toggle="tooltip" title="Register for Leader Registration">Register NOW</a>
                      </p>
                    @endif
                </div>
            </div>
         </div>
       </div>
   </section><!-- section END-->
<script src="https://use.fontawesome.com/07b0ce5d10.js"></script>
@endsection
