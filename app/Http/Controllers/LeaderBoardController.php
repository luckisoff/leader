<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\LeaderBoard;
use App\User;
class LeaderBoardController extends Controller
{
    public function save(Request $request){
        
        
        
            $leaderboard=LeaderBoard::where('user_id',$request->user_id)->first();
            
            if(!$leaderboard){
                $leaderboard=new LeaderBoard();
                $leaderboard->user_id=$request->user_id;
                $leaderboard->point=$request->point;
                $leaderboard->save();
                return $leaderboard;
            }
            
            $leaderboard->point += $request->point;
            $leaderboard->update();
            return $leaderboard;

    } 
    
    public function get($user_id){
        $leaderboard=Leaderboard::where('user_id',$user_id)->first();
        return $leaderboard;
    }
    
    public function get_leader_users(){
       $leaderboards=LeaderBoard::orderBy('point','desc')->limit(13)->get(['point','user_id']);
        
        foreach($leaderboards as $leader){
            $user=User::where('id',$leader->user_id)->first();
            $leader->name=isset($user->name)?$user->name:null;
            $leader->picture=isset($user->picture)?$user->picture:null;
        }
        return $leaderboards;
    }
}
