<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\LeaderBoard;
use App\LeaderAmountWithDraw as Withdraw;
use Illuminate\Support\Facades\Validator;

class LeaderAmountWithdrawController extends Controller
{
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'user_id'=>'required',
            'amount'=>'required',
            'mobile'=>'required|max:10',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>false,
                'code'=>200,
                'message'=>$validator->errors()->first(),
                'data'=>''
            ]);
        }

        $leaderBoard=LeaderBoard::where('user_id',$request->user_id)->first();

        if($request->amount>$leaderBoard->point)
        {
            return response()->json([
                'status'=>false,
                'code'=>200,
                'message'=>'Not enough balance',
                'data'=>''
            ]);
        }

        $withdraw=WithDraw::where('user_id',$request->user_id)->where('status',0)->first();

        if($withdraw)
        {
            return response()->json([
                'status'=>false,
                'code'=>200,
                'message'=>'Already Claimed',
                'data'=>''
            ]);
        }

        $withdraw=WithDraw::create([
            'user_id'=>$request->user_id,
            'amount'=>$request->amount,
            'type'=>$request->type,
            'mobile'=>$request->mobile,
            'status'=>0,
        ]);

        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Amount claim successful',
            'data'=>$withdraw
        ]);

    }

    public function index()
    {
        $withdraws=Withdraw::where('status',0)->with('user')->orderBy('created_at','desc')->get();
        return view('admin.withdraw.user-withdraw')->with('withdraws',$withdraws)->with('page','');
    }

    public function paid()
    {
        $withdrawPaids=Withdraw::where('status',1)->with('user')->orderBy('updated_at','desc')->get();
        return view('admin.withdraw.user-paid')->with('withdrawPaids',$withdrawPaids)->with('page','');
    }

    public function checkStatus($user_id)
    {
        $withdraw=WithDraw::where('user_id',$user_id)->where('status',0)->first();
        if($withdraw)
        {
            return response()->json([
                'status'=>true,
                'code'=>200,
                'message'=>'Already Claimed',
                'data'=>''
            ]);
        }

        return response()->json([
            'status'=>false,
            'code'=>200,
            'message'=>'Not yet claimed',
            'data'=>''
        ]);
    }

    public function update(WithDraw $withdraw)
    {
        $leaderBoard=LeaderBoard::where('user_id',$withdraw->user_id)->first();

        if($withdraw->amount>$leaderBoard->point)
        {
            return redirect('admin/user/withdraw/claims')->with('flash-error','Payment status change error');
        }

        $leaderBoard->point -=$withdraw->amount;
        $leaderBoard->update();
        $withdraw->status=1;
        if($withdraw->update())
        {
            Helper::send_withdraw_sms($withdraw);
        }
        return redirect('admin/user/withdraw/claims')->with('flash-success','Sms sent and Payment status changed');
    }
}
