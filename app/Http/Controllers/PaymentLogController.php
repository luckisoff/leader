<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentLog;
class PaymentLogController extends Controller
{
    public function index()
    {
        $paymentlogs=PaymentLog::where('status',0)->orderBy('created_at','desc')->get();
        return view('admin.withdraw.paymentlog')->with('paymentlogs' , $paymentlogs)->withPage('paymentlog')->with('sub_page','view-stories');
    }
}
