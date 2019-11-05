<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Transaction;
use App\User;
class TransactionController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function index($user_id){
        $earnings=Transaction::where('user_id',$user_id)->orderBy('created_at','desc')->get();
        $user=User::where('id',$user_id)->first();
        return view('admin.earning.index')->with('earnings' , $earnings)
        ->with('user',$user)->withPage('earnings')->with('sub_page','view-stories');
   
    }
}
