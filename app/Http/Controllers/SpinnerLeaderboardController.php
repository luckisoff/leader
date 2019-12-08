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

        $spinenrUser->point +=$request->point;
        $spinenrUser->update();

        $dailyPoint=$this->setDailyPoint($request);

        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Point Added',
            'data'=>[
                'leader_board'=>$spinenrUser,
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


    public function previousWinners()
    {
        $topTenUsers=DailyPoint::orderBy('point','desc')->join('users',function($join){
            $join->on('user_id','=','users.id');
        })->select('spinner_daily_points.user_id','spinner_daily_points.point','users.name','users.picture','users.email','spinner_daily_points.created_at')
        ->whereDate('spinner_daily_points.created_at','<',\Carbon\Carbon::today())
        ->whereDate('spinner_daily_points.created_at','>=',\Carbon\Carbon::yesterday())->limit(5)->get();
        
        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Previous Winner',
            'data'=>$topTenUsers
        ]);
    }

    protected function setDailyPoint(Request $request)
    {
        $dailyPoint=DailyPoint::where('user_id',$request->user_id)->where('created_at','>=',\Carbon\Carbon::today())->first();

        $dailyPoint->point += $request->point;

        if($dailyPoint->available_spin>0)
        {
            $dailyPoint->available_spin -= 1;
        }
       
        $dailyPoint->update();
        
        return $dailyPoint;
    }

    public function addSpin(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'user_id'=>'required',
            'point'=>'required:max:2'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>false,
                'code'=>200,
                'data'=>''
            ]);
        }

        $dailyPoint=DailyPoint::where('user_id',$request->user_id)->where('created_at','>=',\Carbon\Carbon::today())->first();
        $spinenrUser=SpinnerLeaderboard::where('user_id',$request->user_id)->first();

        if($request->watch_video==1)
        {
            $dailyPoint->available_spin += 1;
        }
        
        $dailyPoint->point+=$request->point;
        $dailyPoint->update();

        $spinenrUser->point +=$request->point;
        $spinenrUser->update();

        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Available Spin Added',
            'data'=>[
                'daily_point'=>$dailyPoint,
                'spinner_leader'=>$spinenrUser
            ]
        ]);
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
                'available_spin'=>20,
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
        $spinnerLandmark=SpinnerLandmark::orderBy('point','asc')->get();
        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Spinner landmark list',
            'data'=>$spinnerLandmark
        ]);
    }

    protected function updatePoint(Request $request)
    {
        $dailyPoint=DailyPoint::where('user_id',$request->user_id)->where('created_at','>=',\Carbon\Carbon::today())->first();
        $spinnerUser=SpinnerLeaderboard::where('user_id',$request->user_id)->first();
        $dailyPoint->point +=$request->point;
        $spinnerUser->point +=$request->point;
        $dailyPoint->update();
        $spinnerUser->update();
        
        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Point Updated',
            'data'=>[
                'leader_board'=> $spinnerUser,
                'daily_point'=>$dailyPoint
            ]
        ]);
    }
    
    public function checkIn(Request $request)
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

        $dailyPoint=DailyPoint::where('user_id',$request->user_id)->where('created_at','>=',\Carbon\Carbon::today())->first();
        if(!$dailyPoint)
        {
            return response()->json([
                'status'=>false,
                'code'=>200,
                'message'=>'No user present',
                'data'=>''
            ]);
        }
        if($dailyPoint->check_in==1)
        {
            return response()->json([
                'status'=>true,
                'code'=>200,
                'message'=>'Already Checked In',
                'data'=>$dailyPoint
            ]);
        }
        $dailyPoint->check_in=1;
        $dailyPoint->update();
        
        return $this->updatePoint($request);
    }

    public function isCheckedIn($user_id)
    {
        $dailyPoint=DailyPoint::where('user_id',$user_id)->where('check_in',1)->where('created_at','>=',\Carbon\Carbon::today())->first();
        if($dailyPoint)
        {
            return response()->json([
                'status'=>true
            ]);
        }
        return response()->json([
            'status'=>false
        ]);
    }
}
