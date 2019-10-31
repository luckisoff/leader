@extends('layouts.admin')

@section('title', 'View Audition Registration List')

@section('content-header', 'View Audition Registration List')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-bookmark"></i> View Audition Registration List</li>
@endsection

@section('css')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
@endsection

@section('content')
    @include('notification.notify')

    <div class="row">
        <div class="col-md-12">

        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">

            <div class="box">
                <div class="box-body">
                    <a href="{{ route('audition.view-audition') }}" class="btn btn-sm btn-success"><i class="fa fa-arrow-circle-left"></i> Back</a>
                    <hr>
                    <div id="error" class="alert alert-danger" style="display: none;">
                        <p><i class="fa fa-times"></i> There was some error with the payment. Please Try Again</p>
                    </div>
                    <h3 >Pay with Paypal</h3>
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>
    </div>
@include('admin.audition.modal')

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
                    }).then(dataWrappedByPromise => dataWrappedByPromise.json())
                        .then(data => {
                            // you can access your data here
                            console.log(data)
                            console.log(data.error);
                            if(data.error == 'false'){
                                $('#payment_info').modal("show");
                            }
                            else{
                                $('#error').show();
                            }
                        })





                      /*  .then(function(res) {
                        console.log(res.json());
                        var p = Promise.resolve(res);
                        p.then(function(v) {
                            console.log('helo');
                            console.log(v); // 1
                        });
                        // return res.json();
                    });*/
                });
            }
        }).render('#paypal-button-container');
    </script>
@endsection
