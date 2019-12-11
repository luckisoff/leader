<?php
namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Location;
use App\Audition;
class WebPaymentController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }
    public function register()
    {
        $locations=Location::orderBy('location','asc')->get();
        $user=Auth::user();
        $audition=Audition::where('email',$user->email)->first();
        return view('payment.register',compact('user','locations','audition'));
    }

    public function storeRegistration(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required|unique:audition_registration',
        ]);
        
        $audition=new Audition();
        $audition->user_id=Auth::User()->id;
        $audition->name=$request->name;
        $audition->number=$request->phone;
        $audition->address=$request->address;
        $audition->gender=$request->gender;
        $audition->email=$request->email;
        $audition->save();
        if($audition)
        {
            return redirect('/web/audition/payment');
        }
    }

    //Esewa success method
    public function esewaSuccess()
    {

    }

    //Esewa failure method
    public function esewaCancel()
    {

    }
}
