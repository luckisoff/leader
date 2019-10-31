@extends('layouts.admin')

@section('title', 'View Audition Registration List')

@section('content-header', 'View Audition Registration List')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-bookmark"></i> View Audition Registration List</li>
@endsection

@section('css')

@endsection

@section('content')

    @include('notification.notify')


    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">

                    @if(count($contestant) > 0)
                        <div class="table-responsive">
                        <table id="example1" class="table  table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Contestant Name</th>
                                <th>Contact Number</th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th>Email </th>
                                {{--<th>Image</th>--}}
                                <th>Payment Status</th>
                                <th>Payment Option</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                                @foreach($contestant as $key =>  $value)

                                <tr>
                                    <td> {{ $key + 1 }}.</td>
                                    <td> {{ $value->name }}</td>

                                    <td>
                                        {{$value->number }}
                                    </td>

                                    <td> {{  $value->address }} </td>

                                    <td>
                                        {{  ucfirst($value->gender) }}
                                    </td>

                                    <td>{{ $value->email }}</td>

                                    {{--<td>--}}
                                        {{--<a   style="max-width:100%; height: 100px;" href="{{asset($value->attachment)}}" target="_blank" alt="Attachment MP3 file">--}}
                                            {{--<i class="fa fa-music"> </i> PLay now--}}
                                        {{--</a>--}}
                                    {{--</td>--}}

                                    <td style="width:10px;">
                                        @if($value->payment_status == 1)
                                            <i style="color:green;padding-left:25px; " class="fa fa-check-circle"></i>
                                        @else
                                            <i style="color:red; padding-left:25px; " class="fa fa-times-circle"></i>
                                        @endif
                                    </td>

                                    <td style="width:55px;">
                                        @if($value->payment_status == 0)
                                          <div class="row">
                                              <div style="float: left;padding-left: 5px;">
                                                  <a href="{{ route('khalti.view-khalti',array('user_id' => $value->id,'user_type' => 'admin')) }}">
                                                      <img title="Khalti" class="img img-responsive" style="max-width:100%; height: 40px;" src="{{asset('images/khalti.png')}}" alt="Pay With Khalti">
                                                  </a>
                                              </div>

                                              <div style="float: left; padding-left: 5px; padding-top:7px;">
                                                  <a href="{{ route('stripe.view-stripe',array('user_id' => $value->id,'user_type' => 'admin')) }}">
                                                      <img title="Stripe" class="img img-responsive" style="max-width:100%; height: 25px;" src="{{asset('images/stripe.png')}}" alt="Pay With Khalti">
                                                  </a>
                                              </div>

                                              <div style="float: left; padding-top:7px;">
                                                  <a href="{{ route('paypal.view-paypal',array('user_id' => $value->id)) }}">
                                                      <img title="Paypal" class="img img-responsive" style="max-width:100%; height: 25px;" src="{{asset('images/paypal.png')}}" alt="Pay With Khalti">
                                                  </a>
                                              </div>

                                          </div>
                                        @else
                                            <span class="label label-success">
                                                <i  class="fa fa-check-circle"> Paid</i>
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <ul class="admin-action btn btn-default">
                                            <li class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                    Action <span class="caret"></span>
                                                </a>

                                                <ul class="dropdown-menu">

                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="{{route('audition.edit-audition-form', array('id' => $value->id))}}">
                                                            <i class="fa fa-pencil"></i>Edit
                                                        </a>
                                                    </li>


                                                    <li role="presentation">
                                                        @if(Setting::get('admin_delete_control'))

                                                            <a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>

                                                        @else
                                                            <a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="{{route('audition.delete-audition',array('id' => $value->id))}}">
                                                                <i class="fa fa-trash"></i>Delete
                                                            </a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </td>
                                </tr>

                                @endforeach

                        </tbody>
                        </table>
                        </div>
                    @else
                        <h3 class="no-result">No results found</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection