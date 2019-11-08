<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Livequiz;
use App\LiveQuizCorrectUser;
use App\LeaderBoard;
use Illuminate\Support\Facades\Validator as LiveValidator;


class LivequizController extends Controller
{
    protected function index($question_id,$correctUser='')
    {
        $totalLiveUsers=Livequiz::where('question_id',$question_id)->count();
        $options=Livequiz::where('question_id',$question_id)->pluck('option')->toArray();
        $users=[];
        foreach($options as $option)
        {
            $users[$option]=count(Livequiz::where('question_id',$question_id)->where('option',$option)->get());
        }
        return response()->json([
            'response'  =>true,
            'status'=>200,
            'data'=>[
                'totalusers'=>$totalLiveUsers,
                'userInfo'=>$correctUser->select('user_id','question_set','correct as is_eligible')->first(),
                'users'=>$users
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator=LiveValidator::make($request->all(),[
             'user_id'=>'required',
            'question_set'=>'required',
            'option'=>'required',
            'question_id'=>'required',
            'point'=>'required',
            'time'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['status'=>false,'message'=>'Error','data'=>$validator->errors()->first()]);
        }
        $livequiz=new Livequiz();
        $livequiz->user_id=$request->user_id;
        $livequiz->question_set=$request->question_set;
        $livequiz->question_id=$request->question_id;
        $livequiz->option=$request->option;
        $livequiz->answer=$request->answer?$request->answer:0;
        $livequiz->time=$request->time;
        $livequiz->prize=$request->prize?$request->prize:'';
        $livequiz->point=$request->point?$request->point:0;
        $livequiz->save();

        $this->updateLeaderBoard($livequiz->user_id,$livequiz->point);

        $correctUser=$this->saveCorrectUserData($livequiz,$request);

        return $this->index($livequiz->question_id,$correctUser);
    }

    
    public function getWinner()
    {
        $winner=LiveQuizCorrectUser::leftJoin('users',function($join){
            $join->on('live_quiz_correct_users.user_id','=','users.id');
        })
        ->where('live_quiz_correct_users.created_at','>=',\Carbon\Carbon::today())
        ->where('correct',1)->orderBy('total_time','asc')->get();

        $winner=$winner->groupBy('total_time')->first();
        if(count($winner)>1){
            $winner=$winner->random(1);
        }

        \App\Winner::create([
            'user_id'=>$winner->user_id,
            'question_set'=>$winner->question_set,
            'point'=>$winner->point,
            'prize'=>$winner->prize,
            'quiz_data'=>$winner->created_at
        ]);
        return $winner;
    }


    public function getAllTimeWinners()
    {
        $winners=Winner::orderBy('created_at','desc')->get();
        return $winners;
    }


    protected function updateLeaderBoard($user_id,$point)
    {
        $leaderboard=LeaderBoard::where('user_id',$user_id)->first();
        if($leaderboard)
        {
            $leaderboard->point +=$point;
            $leaderboard->update();
        }
    }

    protected function saveCorrectUserData(Livequiz $livequiz,Request $request)
    {
        $liveQuizCorrectUser=LiveQuizCorrectUser::where('user_id',$request->user_id)->first();

        $options =\App\Option::where('question_id',$request->question_id)->select('name','answer')->get();
        
        $answerStatus=false;
        foreach($options as $option){
            if($option->name ==$livequiz->option && $option->answer==1){
                $answerStatus=true;
            }
        }
        
        
            if($liveQuizCorrectUser){
                $liveQuizCorrectUser->total_time +=$livequiz->time;
                $liveQuizCorrectUser->point +=$livequiz->point;
                $liveQuizCorrectUser->update();
            }else{
                $liveQuizCorrectUser=new LiveQuizCorrectUser();
                $liveQuizCorrectUser->user_id=$request->user_id;
                $liveQuizCorrectUser->question_set=$request->question_set;
                $liveQuizCorrectUser->correct=$answerStatus?1:0;
                $liveQuizCorrectUser->prize=$request->prize?$request->prize:'';
                $liveQuizCorrectUser->point=$request->point?$request->point:'';
                $liveQuizCorrectUser->total_time=$request->time;
                $liveQuizCorrectUser->save();
                return $liveQuizCorrectUser;
            }
        
            if(!$answerStatus){
                $liveQuizCorrectUser->prize=0;
                $liveQuizCorrectUser->point +=$livequiz->point;
                $liveQuizCorrectUser->correct=0;
                $liveQuizCorrectUser->update();
            }
        

        return $liveQuizCorrectUser;
    }

}
