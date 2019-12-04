@extends('layouts.user')

@section('content')

    <div class="row">
        <div class="col-md-12">

            @if(isset($payment))
                @if($payment == 'success')
                    <div class="col-md-6 well">
                        <h2 style="color:darkred;" class="alert alert-danger">Your Payment is Successfull</h2>
                    </div>
                @elseif($payment == 'fail')
                    <p style="color:red;">* There was some error with the payment. Please Try Again.</p>
                    <a href="{{ route('select-payment',['user_id'=>1]) }}">Pay Again</a>
                @endif
            @else

                {{--stripe--}}
                <div class="col-md-6 well">
                    {{--integrate using checkout js--}}
                    <form action="{{ route('stripe.integrate-user-stripe') }}" method="POST">
                        <h3  style="color:darkred;">Pay with Stripe</h3>
                        <img title="Stripe Payment" class="img img-responsive" style="max-width:100%; height: 50px; margin-bottom:15px;" src="{{asset('images/stripe.png')}}" alt="Pay With Khalti">

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

                <div class="col-md-1">

                </div>

                {{--khalti view--}}
                <div class="col-md-5 well">
                    <h3 style="color:darkred;">Pay with Khalti</h3>
                    <input type="hidden" id="user_id" value="{{ $user_id }}">
                    <input type="hidden" id="user_type" value="{{ $user_type}}">
                    <img title="Khalti Payment" class="img img-responsive" style="max-width:100%; height: 65px;" src="{{asset('images/khalti.png')}}" alt="Pay With Khalti">
                    <button id="payment-button"  class="btn btn-success"><i class="fa fa-dollar"></i>Pay with Khalti</button>
                </div>
            @endif




        </div>

    </div>


@endsection



@section('scripts')
    {{--khalti integration--}}
    <script src="https://khalti.com/static/khalti-checkout.js"></script>
    <script>
        // $(function () {
        var user_type = $("#user_type").val();
        var config = {
            // replace the publicKey with yours
            "publicKey": "test_public_key_988f9cb4133048e5b40e8eb6814fe537",
            "productIdentity": $("#user_id").val(),
            "productName": "Audition Form",
            "productUrl": "http://localhost/bharyang/infinity/admin/audition",
            "eventHandler": {
                onSuccess (payload) {
                    // hit merchant api for initiating verfication
                    // console.log(payload);
                    window.location.replace("http://localhost/bharyang/audition/khalti/integrate?token="+payload.token+"&amount="+payload.amount+"&user_id="+payload.product_identity+"&user_type="+user_type);
                },
                onError (error) {
                    console.log(error);
                },
                onClose () {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function () {
            checkout.show({amount: 1000});
        }

    </script>
@endsection
