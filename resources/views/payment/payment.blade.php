@extends('layouts.user.focused')

@section('content')
<style type="text/css">
.esewa{
    margin: 0;
    padding: 0 0 6px 15px;
}
.khalti{
    margin: 0;
    padding: 0 19px 6px 5px;
}
.esewa img, .khalti img{
    width: 170px;
    height: 80px;
}
</style>
    <div class="login-box">
        <h4>{{tr('Payment Method')}}</h4>

            <h5>Pay With</h5>
            <div class="row payment-method">
                <div class="esewa col-sm-6">
                    <button onclick="document.getElementById('esewaPayment').submit();">
                        <img src="{{ asset('images/esewa-logo.jpg') }}" class="img-responsive">
                    </button>
                </div>
                <div class="khalti col-sm-6">
                    <button onclick="khaltiPayment(1000)">
                        <img src="{{ asset('images/khalti-logo.jpg') }}" class="img-responsive">
                    </button>
                </div>
            </div>
            <div class="row">
                ]<div class="col-sm-6">
                    <div class="payment-method">
                        <button id="paypal-button">
                        </button>
                    </div>
                </div>
            </div>

            <form id="esewaPayment" action="https://uat.esewa.com.np/epay/main" method="POST">
                <input value="100" name="tAmt" type="hidden">
                <input value="90" name="amt" type="hidden">
                <input value="5" name="txAmt" type="hidden">
                <input value="2" name="psc" type="hidden">
                <input value="3" name="pdc" type="hidden">
                <input value="NP-ES-SRBN" name="scd" type="hidden">
                <input value="{{'Leader-Audition-'.Auth::user()->id}}" name="pid" type="hidden">
                <input value="{{env('APP_URL').'/web/audition/esewa/success'}}" type="hidden" name="su">
                <input value="{{env('APP_URL').'/web/audition/esewa/failure'}}" type="hidden" name="fu">
            </form>

    </div>
<script src="https://khalti.com/static/khalti-checkout.js"></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script type="text/javascript">
    var config = {
        // replace the publicKey with yours
        "publicKey": '{{config('services.khalti.client_id')}}',
        "productIdentity": "1234567890",
        "productName": "Dragon",
        "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
        "eventHandler": {
            onSuccess (payload) {
                $.ajax({
                    url:'{{env('APP_URL')."/web/audition/khalti/success"}}',
                    type:"POST",
                    dataType:"JSON",
                    data:payload,
                    success:function(response){
                        console.log(payload);
                        console.log(response.status);
                        if(response.status)
                        {
                            window.location.href='{{env('APP_URL')."/web/audition/register"}}';
                        }
                        
                    },
                    error:function()
                    {
                        window.location.href='{{env('APP_URL')."/web/audition/payment"}}';
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

    paypal.Button.render({
    // Configure environment
        env: 'sandbox',
        client: {
          sandbox: 'AeK_uXchdPl_ctu5zY9C4mtdHDo6_pNihxDSgFU6PkDWvre1oJbu-y9xL67mCoyLUZ5bspN9TtBP8I3a',
          production: 'demo_production_client_id'
        },
        // Customize button (optional)
        locale: 'en_US',
        style: {
            layout: 'horizontal',
            size: 'large',
            color: 'gold',
            shape: 'pill',
        },

        // Enable Pay Now checkout flow (optional)
        commit: true,

        // Set up a payment
        payment: function(data, actions) {
          return actions.payment.create({
            transactions: [{
              amount: {
                total: '31.3',
                currency: 'USD',
                details: {
                  subtotal: '30.00',
                  tax: '1.3',
                }
              }
            }]
          });
        },
        // Execute the payment
        onAuthorize: function(data, actions) {
          return actions.payment.execute().then(function() {
            // Show a confirmation message to the buyer
            window.alert('Thank you for your purchase!');
          });
        }
      }, '#paypal-button');

</script>
@endsection
