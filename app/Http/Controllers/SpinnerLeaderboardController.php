<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SpinnerLeaderboard;
use Illuminate\Support\Facades\Validator;
use App\SpinnerDailyPoint as DailyPoint;
use App\SpinnerLandmark;

class SpinnerLeaderboardController extends Controller
{
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'user_id'=>'required',
            'point'=>'required:max:2'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>false,
                'message'=>$validator->errors()->first(),
                'data'=>''
            ]);
        }
        $spinenrUser=SpinnerLeaderboard::where('user_id',$request->user_id)->first();
        $dailyPoint=$this->setDailyPoint($request);

        $spinenrUser->point +=$request->point;
        $spinenrUser->save();

        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Point Added',
            'data'=>[
                'leader_board'=>$spinenrUser->with('user')->get(),
                'daily_point'=>$dailyPoint
            ]
        ]);
    }

    public function topTenUsers()
    {
        $topTenUsers=SpinnerLeaderboard::orderBy('point','asc')->join('users',function($join){
            $join->on('user_id','=','users.id');
        })->select('spinner_leaderboards.user_id','spinner_leaderboards.point','users.name','users.picture','users.email')
        ->limit(10)->get();
        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Top Ten Users',
            'data'=>$topTenUsers
        ]);
    }

    protected function setDailyPoint(Request $request)
    {
        $dailyPoint=DailyPoint::where('user_id',$request->user_id)->where('created_at','>=',\Carbon\Carbon::today())->first();

        $dailyPoint->point += $request->point;
        $dailyPoint->available_spin -= 1;
        $dailyPoint->save();
        
        return $dailyPoint;
    }

    public function getUserPoint($user_id)
    {
        $spinenrUser=SpinnerLeaderboard::where('user_id',$user_id)->first();
        $dailyPoint=DailyPoint::where('user_id',$user_id)->where('created_at','>=',\Carbon\Carbon::today())->first();
        if(!$dailyPoint)
        {
            $dailyPoint=DailyPoint::firstOrcreate([
                'user_id'=>$user_id,
                'point'=>0,
                'available_spin'=>20
            ]);
        }

        if(!$spinenrUser)
        {
            $spinenrUser= SpinnerLeaderboard::create([
                'user_id'=>$user_id,
                'point'=>0
            ]);
        }
        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Users point',
            'data'=>[
                'daily'=>$dailyPoint,
                'overal'=> $spinenrUser
            ]
        ]);
    }

    public function getLandmark()
    {
        $spinnerLandmark=SpinnerLandmark::orderBy('created_at','desc')->get();
        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Spinner landmark list',
            'data'=>$spinnerLandmark
        ]);
    }
}
