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
            <div class="alert alert-danger" id="error_msg" style="display:none">
            </div>
            <div class="row payment-method">
                <div class="esewa col-sm-6">
                    <button onclick="document.getElementById('esewaPayment').submit();">
                        <img src="{{ asset('images/esewa-logo.jpg') }}" class="img-responsive">
                    </button>
                </div>
                <div class="khalti col-sm-6">
                    <button onclick="khaltiPayment(1000*100)">
                        <img src="{{ asset('images/khalti-logo.jpg') }}" class="img-responsive">
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="paypal-button-container"></div>
                </div>
            </div>

            <form id="esewaPayment" action="https://esewa.com.np/epay/main" method="POST">
                <input value="10" name="tAmt" type="hidden">
                <input value="10" name="amt" type="hidden">
                <input value="0" name="txAmt" type="hidden">
                <input value="0" name="psc" type="hidden">
                <input value="0" name="pdc" type="hidden">
                <input value="NP-ES-SRBN" name="scd" type="hidden">
                <input value="{{'LEADERAUDITION-SRBN-'.rand(1,900)}}" name="pid" type="hidden">
                <input value="{{env('APP_URL').'/web/audition/esewa/success'}}" type="hidden" name="su">
                <input value="{{env('APP_URL').'/web/audition/esewa/failure'}}" type="hidden" name="fu">
            </form>

    </div>
<script src="https://khalti.com/static/khalti-checkout.js"></script>
<!-- <script src="https://www.paypalobjects.com/api/checkout.js"></script> -->
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
                    url:'{{env('APP_URL')."/web/audition/khalti/success"}}',
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

                        // window.location.href='{{env('APP_URL')."/web/audition/payment"}}';
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

    // if(getParamValue('msg')) 
    // { 
    //     alert(getParamValue('msg'));
        
    // } 

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
                        value: '15'
                    }
                }]
            });
        },

        // Finalize the transaction
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Show a success message to the buyer
                $.ajax({
                    url:'{{env('APP_URL')."/web/audition/paypal/success"}}',
                    type:"POST",
                    dataType:"JSON",
                    data:details,
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
                alert('Transaction completed by ' + details.payer.name.given_name + '!');
            });
        }

      }).render('#paypal-button-container');;

</script>
@endsection
