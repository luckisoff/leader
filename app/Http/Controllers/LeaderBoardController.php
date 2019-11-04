<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\LeaderBoard;
use App\User;
use Illuminate\Support\Facades\Hash;
class LeaderBoardController extends Controller
{
    public function save(Request $request){
        
            $leaderboard=LeaderBoard::where('user_id',$request->user_id)->first();
            
            $paisa =  $request->point/100;

            if(!$leaderboard){
                $leaderboard=new LeaderBoard();
                $leaderboard->user_id=$request->user_id;
                $leaderboard->point=$paisa;
                $leaderboard->level=$request->has('level')?$request->level:'';
                $leaderboard->save();
                return $leaderboard;
            }
            
            $leaderboard->point += $paisa;
            $leaderboard->level=$request->has('level')?$request->level:'';
            $leaderboard->update();
            return $leaderboard;

    } 
    
    public function getPoints($user_id){
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
    
    public function get_leader_users(){
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

}
