@extends('layouts.user.focused')

@section('content')
<style type="text/css">
.login-box{
    background-color: #d4d3d2;
}
.login-box h4, .login-box h5{
    color: rgb(44, 46, 47) !important;

}
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
                <div class="col-sm-12">
                    <div id="paypal-button-container"></div>
                </div>
            </div>

            <form id="esewaPayment" action="https://uat.esewa.com.np/epay/main" method="POST">
                <input value="100" name="tAmt" type="hidden">
                <input value="90" name="amt" type="hidden">
                <input value="5" name="txAmt" type="hidden">
                <input value="2" name="psc" type="hidden">
                <input value="3" name="pdc" type="hidden">
                <input value="NP-ES-SRBN" name="scd" type="hidden">
                <!-- <input value="ee2c3ca1-696b-4cc5-a6be-2c40d929d453" name="pid" type="hidden"> -->
                <input value="http://merchant.com.np/page/esewa_payment_success?q=su" type="hidden" name="su">
                <input value="http://merchant.com.np/page/esewa_payment_failed?q=fu" type="hidden" name="fu">
            </form>

    </div>
<script src="https://khalti.com/static/khalti-checkout.js"></script>
<!-- <script src="https://www.paypalobjects.com/api/checkout.js"></script> -->
 <script src="https://www.paypal.com/sdk/js?client-id=AeK_uXchdPl_ctu5zY9C4mtdHDo6_pNihxDSgFU6PkDWvre1oJbu-y9xL67mCoyLUZ5bspN9TtBP8I3a&currency=USD"></script>
<script type="text/javascript">
    var config = {
        // replace the publicKey with yours
        "publicKey": "test_public_key_dc74e0fd57cb46cd93832aee0a390234",
        "productIdentity": "1234567890",
        "productName": "Dragon",
        "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
        "eventHandler": {
            onSuccess (payload) {
                // hit merchant api for initiating verfication
                console.log(payload);
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
    // Configure environment
        // env: 'sandbox',
        // client: {
        //   sandbox: 'AeK_uXchdPl_ctu5zY9C4mtdHDo6_pNihxDSgFU6PkDWvre1oJbu-y9xL67mCoyLUZ5bspN9TtBP8I3a',
        //   production: 'demo_production_client_id'
        // },
        // Customize button (optional)
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
                        value: '5'
                    }
                }]
            });
        },

        // Finalize the transaction
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Show a success message to the buyer
                alert('Transaction completed by ' + details.payer.name.given_name + '!');
            });
        }

      }).render('#paypal-button-container');;

</script>
@endsection
