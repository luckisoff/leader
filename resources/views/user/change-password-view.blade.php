@extends('layouts.user.focused')

@section('content')
   <section class="dashboard edit-profile">
    <div class="row userinfo">
      <div class="col-sm-12">
         <div class="jumbotron">
            <div class="row">
               <div class="col-md-9 col-xs-12 col-sm-6 col-lg-9">
                   <form action="{{ route('user.update.password') }}" method="POST" enctype="multipart/form-data">
                       <div class="login-box">
                         <p class="help"><a class="action" href="{{route('web-leader-dashboard')}}">&laquo;&laquo; Go back to Dashboard</a></p>                
                         <h4>{{tr('Change Password')}}</h4>    
                         @include('notification.notify')
                         <form method="post" action="{{ route('user.profile.password') }}">
                           <div class="form-group">
                             <label for="newpwd">Old Password</label>
                             <input type="password" name="old_password" class="form-control" id="newpwd">
                           </div>
                           <div class="form-group">
                             <label for="newpwd">New Password</label>
                             <input type="password" name="password" class="form-control" id="newpwd">
                           </div>
                           <div class="form-group">
                             <label for="cnfrmpwd">Confirm Password</label>
                             <input type="password" name="password_confirmation" class="form-control" id="cnfrmpwd">
                           </div>                                     
                           <button type="submit" class="btn btn-default">{{tr('Save')}}</button>
                         </form>                
                       </div>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </section>
@endsection