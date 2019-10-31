@extends('layouts.user')

@section('content')

        <div class="row">
            <div class="col-md-12">
                        <div class="col-md-8 well">
                            <form class="form-horizontal" method="post"  action="{{ route('stripe.integrate-stripe') }}" >
                                {{ csrf_field() }}
                                <h2 style="color:black;">Stripe Payment</h2>

                                <div class='form-row'>
                                    <div class='col-xs-12 form-group card required'>
                                        <label class='control-label' style="color:black;">Card Number</label>
                                        <input autocomplete='off' class='form-control card-number' size='20' type='text' name="card_no">
                                    </div>
                                    @if($errors->has('mobile_number'))
                                        <span class="help-block" style="color:red;">
                                      * {{ $errors->first('mobile_number') }}
                                  </span>
                                    @endif
                                </div>

                                <div class='form-row'>
                                    <div class='col-xs-4 form-group cvc required'>
                                        <label class='control-label' style="color:black;">CVV</label>
                                        <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvvNumber">
                                        @if($errors->has('mobile_number'))
                                            <span class="help-block" style="color:red;">
                                                * {{ $errors->first('mobile_number') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class='col-xs-4 form-group expiration required'>
                                        <label class='control-label' style="color:black;">Expiration</label>
                                        <input class='form-control card-expiry-month' placeholder='MM' size='4' type='text' name="ccExpiryMonth">
                                        @if($errors->has('mobile_number'))
                                            <span class="help-block" style="color:red;">
                                                * {{ $errors->first('mobile_number') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class='col-xs-4 form-group expiration required'>
                                        <label class='control-label' style="color:black;"> Year</label>
                                        <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' name="ccExpiryYear">
                                        <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='hidden' name="amount" value="300">
                                        @if($errors->has('mobile_number'))
                                            <span class="help-block" style="color:red;">
                                                * {{ $errors->first('mobile_number') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-md-12 form-group' >
                                        <div class='form-control total btn btn-primary' >
                                            Total:
                                            <span class='amount'>$10</span>
                                        </div>
                                    </div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-md-12 form-group'>
                                        <button type='submit' class='form-control btn btn-success' style="margin-top: 10px;" >Pay »</button>
                                    </div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-md-12 error form-group hide'>
                                        <div class='alert-danger alert'>
                                            Please correct the errors and try again.
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

            </div>

            {{--<div class="well"></div>--}}
        </div>

    <div class="row">
        <form action="{{ route('stripe.integrate-stripe') }}" method="POST">
            <input type="text" name="user_id" value="1">
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

@endsection


@section('scripts')
    <script>

    </script>
@endsection
