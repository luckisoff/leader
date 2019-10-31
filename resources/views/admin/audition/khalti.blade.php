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
                    <h3 >Pay with Khalti</h3>
                    <input type="hidden" id="user_id" value="{{ $user_id }}">
                    <input type="hidden" id="user_type" value="{{ $user_type }}">
                    <img title="Click To Pay" id="payment-button" class="img img-responsive" style="max-width:100%; height: 100px;" src="{{asset('images/khalti.png')}}" alt="Pay With Khalti">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
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
                        console.log(payload);
                        alert('here');
                        window.location.replace("http://localhost/bharyang/audition/khalti/integrate?token="+payload.token+"&amount="+payload.amount+"&user_id="+payload.product_identity+"&user_type="+user_type);
                    },
                    onError (error) {
                        alert('Error. Please Try Again');
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
                checkout.show({amount: 2000});
            }


        // });



    </script>
@endsection