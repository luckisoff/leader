@extends('layouts.user.focused')

@section('content')
    <div class="login-box">
    @if(!$audition)
        <h4>{{tr('Leader Registration')}}</h4>

        <form role="form" method="POST" action="{{ url('web/audition/register') }}">
            
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="name">Applicant Name:</label>
                <input type="text" name="name" required class="form-control" id="name" value="{{$user?$user->name:''}}">
                @if($errors->has('name'))
                    <span class="form-error"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="number" name="phone" required class="form-control" id="phone" placeholder="Enter your mobile number">
                @if($errors->has('phone'))
                    <span class="form-error"><strong>{{ $errors->first('phone') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <label for="location">Gender:</label>
                <select name="gender" id="gender" class="form-control">
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" name="email" required class="form-control" id="email" value="{{$user?$user->email:''}}">
                @if($errors->has('email'))
                    <span class="form-error"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <label for="address">Audition Location:</label>
                <select name="address" id="address" class="form-control">
                    <option value="">--Select--</option>
                    @foreach($locations as $location)
                    <option value="{{$location->city}}">{{$location->location.', '.$location->city.', '.$location->country}}</option>
                    @endforeach
                    
                </select>
            </div>

          <button type="submit" class="btn btn-default">{{tr('Register')}}</button>
        </form>                
    @else
        @if($audition->payment_status==1)
            <h4 style="margin-bottom:0px">{{tr('Registration Detail')}}</h4>
            <div class="row">
                    <div class="col-xs-12">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-xs-12">
                                    <img src="http://placehold.it/380x500" alt="" class="img-rounded img-responsive" />
                                </div>
                                <div class="col-xs-12">
                                    <h4>{{$audition->name}}</h4>
                                    <small><cite title="{{$audition->address}}">{{$audition->address}}<i class="glyphicon glyphicon-map-marker">
                                    </i></cite></small>
                                    <p>
                                        <i class="glyphicon glyphicon-envelope"></i>{{$audition->email}}
                                        <br />
                                        <i class="glyphicon glyphicon-user"></i>{{$audition->gender}}
                                        <br />
                                        <i class="glyphicon glyphicon-money"></i>{{$audition->payment_status?'Paid':'Error...!'}}
                                        <br />
                                        <i class="glyphicon glyphicon-code"></i>{{$audition->registration_code}}
                                    </p>
                                    <!-- Split button -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @else
            <a href="#" style="color:#ffffff"><h4 style="margin-bottom:0px">{{tr('Pay')}}</h4></a>
        @endif
    @endif 
    </div>

@endsection
