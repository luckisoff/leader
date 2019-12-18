@extends('layouts.user.focused')

@section('content')
<style type="text/css">
.esewa{
    margin: 0;
    padding: 0 0 5px 15px;
}
.khalti{
    margin: 0;
    padding: 0 0 5px 3px;
}
.esewa img, .khalti img{
    width: 177px;
    height: 87px;
    border-radius: 3px;
}
.payment-method button{
    margin: 0;
    padding: 0;
}
@media screen and (max-width: 767px) {
    .khalti{
        padding: 0 0 5px 15px;
    }
    .esewa img, .khalti img{
        width: auto;
        height: auto;
    }
}
</style>
    <div class="login-box">
        <h4>{{tr('Payment Method')}}</h4>

            @if(session('message'))
                <h6 class="alert alert-warning">{{session('message')}}</h6>
            @endif

            <h5>Pay With</h5>
            <div class="alert alert-danger" id="error_msg" style="display:none">
            </div>
            <div class="row payment-method">
                <div class="esewa col-sm-6">
                    <button onclick="document.getElementById('esewaPayment').submit();">
                        <img src="{{ asset('images/esewa-logo.jpg') }}" class="img-responsive">
                    </button>
                </div>
                <div class="khalti col-sm-6">
                    <button onclick="khaltiPayment({{config('services.payment.khalti')}})">
                        <img src="{{ asset('images/khalti-logo.jpg') }}" class="img-responsive">
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
            <form id="esewaPayment" action="https://paymentesewa.com.np/epay/main" method="POST">
                <input value="{{config('services.payment.esewa')}}" name="tAmt" type="hidden">
                <input value="{{config('services.payment.esewa')}}" name="amt" type="hidden">
                <input value="0" name="txAmt" type="hidden">
                <input value="0" name="psc" type="hidden">
                <input value="0" name="pdc" type="hidden">
                <input value="NP-ES-SRBN" name="scd" type="hidden">
                <input value="{{'LEADERAUDITION-SRBN-'.Auth::user()->id}}" name="pid" type="hidden">
                <input value="{{URL::to('/').'/web/audition/esewa/success?id='.Auth::user()->id}}" type="hidden" name="su">
                <input value="{{URL::to('/').'/web/audition/esewa/failure?id='.Auth::user()->id}}" type="hidden" name="fu">
            </form>

    </div>
<script src="https://khalti.com/static/khalti-checkout.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id={{config('services.paypal.client_id')}}&currency=USD"></script>
<script type="text/javascript">
    var config = {
        "publicKey": '{{config('services.khalti.client_id')}}',
        "productIdentity": "LEADERSRBNREGISTRATION-{{Auth::user()->id}}",
        "productName": "Dragon",
        "productUrl": "http://gundruknetwork.com/the_leader_audition",
        "eventHandler": {
            onSuccess (payload) {
                $.ajax({
                    url:'{{URL::to('/')."/web/audition/khalti/success"}}',
                    type:"POST",
                    dataType:"JSON",
                    data:payload,
                    success:function(response){
                        if(response.status)
                        {
                            window.location.href='{{env('APP_URL')."/web/audition/register"}}';
                        }
                        window.location.href='{{env('APP_URL')."/web/audition/register"}}';
                    },
                    error:function(error)
                    {
                        document.getElementById("error_msg").style.display = 'block';
                        document.getElementById("error_msg").innerHTML = '<span>Could not process payment at this time.</span>';
                    }
                })
                
            },
            onError (error) {
                console.log(error);
            },
            onClose () {
                console.log('widget is closing');
            }
        }
    };

    function khaltiPayment(totalAmount) {
        var checkout = new KhaltiCheckout(config);
        checkout.show({amount: totalAmount});
    }

    paypal.Buttons({
        locale: 'en_US',
        style: {
            color: 'gold',
            shape: 'rect',
            label: 'pay',
            height: 42,
            size: 'responsive'
        },

        // Set up the transaction
          createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '{{config('services.payment.paypal')}}'
                    }
                }]
            });
        },

        // Finalize the transaction
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Show a success message to the buyer
                $.ajax({
                    url:'{{URL::to('/')."/web/audition/paypal/success"}}',
                    type:"POST",
                    dataType:"JSON",
                    data:details,
                    success:function(response){
                        if(response.status)
                        {
                            window.location.href='{{URL::to('/')."/web/audition/register"}}';
                        }
                        window.location.href='{{URL::to('/')."/web/audition/register"}}';
                    },
                    error:function(error)
                    {
                        
                        document.getElementById("error_msg").style.display = 'block';
                        document.getElementById("error_msg").innerHTML = '<span>Could not process payment at this time.</span>';
                    }
                })
                alert('Transaction completed by ' + details.payer.name.given_name + '!');
            });
        }

      }).render('#paypal-button-container');;

</script>
@endsection
