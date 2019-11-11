<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Livequiz;
use App\LiveQuizCorrectUser;
use App\LeaderBoard;
use App\Winner;
use Illuminate\Support\Facades\Validator as LiveValidator;
use Carbon\Carbon;

class LivequizController extends Controller
{
    protected function index($question_id,$correctUser='')
    {
        $totalLiveUsers=Livequiz::where('question_id',$question_id)->count();
        $options=Livequiz::where('question_id',$question_id)->pluck('option')->toArray();
        $users=[];
        $correctOption =\App\Option::where('question_id',$question_id)->where('answer',1)->pluck('name')->first();
        foreach($options as $option)
        {
            $users[$option]=count(Livequiz::where('question_id',$question_id)->where('option',$option)->get());
        }
        return response()->json([
            'status'  =>true,
            'code'=>200,
            'message'=>'success',
            'data'=>[
                'totalusers'=>$totalLiveUsers,
                'conrrect_option'=>$correctOption,
                'userInfo'=>$correctUser->select('user_id','question_set','correct as is_eligible','live_paid as is_paid')->first(),
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
            'time_taken'=>'required'//time required to answer
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
        ->where('live_quiz_correct_users.created_at','>=',Carbon::today())
        ->where('correct',1)->orderBy('total_time','asc')->get();

        if(!$winner)
        {
            return response()->json([
                'status'=>false,
                'code'=>200,
                'message'=>'No data available.',
                'data'=>''
            ]);
        }

        $winner=$winner->groupBy('total_time')->first();
        if(count($winner)>1){
            $winner=$winner->random(1);
        }

        \App\Winner::create([
            'user_id'=>$winner->user_id,
            'question_set'=>$winner->question_set,
            'point'=>$winner->point,
            'prize'=>$winner->prize,
            'quiz_date'=>$winner->created_at
        ]);

        return respone()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'winner created',
            'data'=>$winner
        ]);
    }


    public function getAllTimeWinners()
    {
        $winners=Winner::orderBy('created_at','desc')->get();
        return view('admin.winner.index',['winners'=>$winners,'page'=>'']);
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
            if($option->name==$livequiz->option && $option->answer==1){
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

    public function quit(Request $request)
    {
        
        $validator=LiveValidator::make($request->all(),[
            'user_id'=>'required'
        ]);      

        if($validator->fails())
        {
            return response()->json(['status'=>false,'code'=>200,'message'=>'Error','data'=>$validator->errors()->first()]);
        }

        $liveQuizUser=LiveQuizCorrectUser::where('user_id',$request->user_id)->where('created_at','>=',Carbon::today())->first();
        $livequizzes=Livequiz::where('user_id',$request->user_id)->where('created_at','>=',Carbon::today())->get();
        if($liveQuizUser){
            $liveQuizUser->delete();
        }
        if($livequizzes){
            foreach($livequizzes as $livequiz){
                $livequiz->delete();
            }
        }

        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'quiting success',
            'data'=>'Thank you for playing. Please come back later.'
        ]);
    }

}
