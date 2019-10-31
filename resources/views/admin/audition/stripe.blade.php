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
                    <a href="{{ route('audition.view-audition') }}" class="btn btn-sm btn-success"><i class="fa fa-arrow-circle-left"></i> Back</a>
                    <h3 >Pay with Stripe</h3>
                    <img title="Stripe Payment" class="img img-responsive" style="max-width:100%; height: 50px; margin-bottom:15px;" src="{{asset('images/stripe.png')}}" alt="Pay With Khalti">

                    <form action="{{ route('stripe.integrate-stripe') }}" method="POST">
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="pk_test_TvBtuG5CRCBJ9ZL0DXbm4tsX00edIVErdy"
                                data-amount="1000"
                                data-name="Junior Vocal Star "
                                {{--data-zip-code="true"--}}
                                data-description="Audition Payment"
                                {{--data-image="https://stripe.com/img/documentation/checkout/marketplace.png"--}}
                                data-image="http://juniorvocalstar.com/wp-content/uploads/2019/07/imageedit_7_5018137365.png"
                                data-locale="auto">
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')

@endsection