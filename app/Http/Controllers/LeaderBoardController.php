<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaderBoard;
use App\User;
use App\Today;
use App\Transaction;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use App\LiveQuizCorrectUser as LiveQuizUser;

class LeaderBoardController extends Controller
{
    public function save(Request $request)
    {    
            $leaderboard=LeaderBoard::where('user_id',$request->user_id)->first();
            
            $paisa =  $request->point/100;

            if(!$leaderboard){
                $leaderboard=new LeaderBoard();
                $leaderboard->user_id=$request->user_id;
                $leaderboard->point=$paisa;
                $leaderboard->level=$request->has('level')?$request->level:0;
                $leaderboard->save();
                return $leaderboard;
            }
            $leaderboard->point += $paisa;
            $leaderboard->level=$request->has('level')?$request->level:0;
            $leaderboard->save();

            $today=Today::where('created_at','>=',\Carbon\Carbon::today())->first();

            if(!$today){
                Today::create([
                    'amount'=>$paisa
                ]);
            }else{
                $today->amount += $paisa;
                $today->save();
            }

            $transaction=new Transaction();
            $transaction->user_id=$request->user_id;
            $transaction->amount=$paisa;
            $transaction->set=$request->has('set')?$request->set:null;
            $transaction->level=$request->has('level')?$request->level:null;
            $transaction->save();
            return response()->json($leaderboard);

    } 
    
    public function getPoints($user_id)
    {
        $members=LeaderBoard::orderBy('point','desc')->get();
        $leaderboard=Leaderboard::where('user_id',$user_id)->first();
        $index='';
        foreach($members as $key=>$member){
            if($leaderboard==$member){
                $index=$key+1;
            }
        }
        $user=User::where('id',$user_id)->first();
        
        $leaderboard['user_name']=$user->name;
        $leaderboard['position']=$index;
        return response()->json($leaderboard);
    }
    
    public function get_leader_users()
    {
       $leaderboards=LeaderBoard::orderBy('point','desc')->limit(53)->get(['point','user_id','level']);
        
        foreach($leaderboards as $key=>$leader){
            $user=User::where('id',$leader->user_id)->first();
            $leader['position']=$key+1;
            $leader->name=isset($user->name)?$user->name:null;
            $leader->email=isset($user->email)?$user->email:null;
            $leader->picture=isset($user->picture)?$user->picture:null;
        }
        return response()->json($leaderboards);
    }

    public function paymentClaim(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'payment_claim'=>'required|max:1',
            'user_id'=>'required'
        ]);

        if($validator->fails()){
            return Helper::setResponse('fails','missing parameter','');
        }
        $leaderBoard=LeaderBoard::where('user_id',$request->user_id)->first();
        
        if(($leaderBoard->payment_claim ==0) && ($request->payment_claim==1)){
            $leaderBoard->payment_claim=1;
            $leaderBoard->point +=1;
            $leaderBoard->update();
            return Helper::setResponse('success','Payment Claimed','');
        }
        $message=$leaderBoard->payment_claim==1?'Already Claimed!':'Could not be claimed this time!';
        return Helper::setResponse('fails',$message,'');
    }

    public function deductUserPoint(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'user_id'=>'required',
            'point_to_deduct'=>'required'
        ]);

        if($validator->fails()){
            return Helper::setResponse('fails',$validator->errors()->all(),'');
        }
        $leaderBoard=LeaderBoard::where('user_id',$request->user_id)->first();
        if($leaderBoard){
            if($request->point_to_deduct>$leaderBoard->point){
                return Helper::setResponse('fails','Not enough point','');
            }
            $leaderBoard->point -=$request->point_to_deduct;

            $liveQuizUser=LiveQuizUser::where('user_id',$request->user_id)->first();
            if($leaderBoard->update() && $liveQuizUser){
                $liveQuizUser->live_paid=1;
                $liveQuizUser->update();
            }
        }
        return Helper::setResponse('success','Leader Board Data',$leaderBoard,'');
    }
    

}
