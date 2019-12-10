<?php
namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WebPaymentController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }
    public function register()
    {
        return view('payment.register');
    }
}
