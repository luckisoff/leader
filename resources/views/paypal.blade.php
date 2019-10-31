@extends('layouts.user')

@section('styles')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div id="paypal-button-container"></div>
        </div>
    </div>


@endsection



@section('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id=ATJ1GvoglUZ0OC0sSc_NAEp7i3XFenLqacg3q6hd9jGGo9LXDYGEv-Qa0KyRVXpLQNnMtYRrJiBRbeId">
    </script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '20.00'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                // Capture the funds from the transaction
                return actions.order.capture().then(function(details) {
                    // Show a success message to your buyer
                    console.log(details);
                    // alert('Transaction completed by ' + details.payer.name.given_name);
                    //server call
                    alert(data.orderID);
                    return fetch('paypal/admin/integrate', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            user_id:1
                        })
                    });
                });
            }
        }).render('#paypal-button-container');
    </script>
@endsection
