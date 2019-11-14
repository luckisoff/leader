<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Livequiz;
use App\LiveQuizCorrectUser;
use App\LeaderBoard;
use App\Winner;
use Illuminate\Support\Facades\Validator as LiveValidator;
use Carbon\Carbon;
use App\QuestionPosition as Position;
use App\LiveQuizUser;

class LivequizController extends Controller
{
   
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

        $registered_user=\App\LiveQuizUser::where('user_id',$request->user_id)->where('created_at','>=',Carbon::today())->first();

        if(!$registered_user)
        {
            return response()->json(['status'=>false,'code'=>200,'message'=>'Not Registerd','data'=>'You are not registerd for this quiz.']);
        }

        $options=\App\Option::where('question_id',$request->question_id)->pluck('name')->toArray();
       
        if(!in_array($request->option,$options))
        {
            return response()->json([
                'status'=>false,
                'code'=>200,
                'message'=>'Option '.$request->option .' is not available',
                'data'=>''
            ]);
        }
        $livequiz=new Livequiz();
        $livequiz->user_id=$request->user_id;
        $livequiz->question_set=$request->question_set;
        $livequiz->question_id=$request->question_id;
        $livequiz->option=$request->option;
        $livequiz->answer=$request->answer?$request->answer:0;
        $livequiz->time=$request->time_taken;
        $livequiz->prize=$request->prize?$request->prize:'';
        $livequiz->point=$request->point?$request->point:0;
        $livequiz->save();

        $this->updateLeaderBoard($livequiz->user_id,$livequiz->point);

        $correctUser=$this->saveCorrectUserData($livequiz,$request);


        return response()->json([
            'status'  =>true,
            'code'=>200,
            'message'=>'success',
            'data'=>$correctUser
        ]);
    }

    
    public function getWinner()
    {
        $is_winner=Winner::leftJoin('users',function($join){
            $join->on('winners.user_id','=','users.id');
        })
        ->where('winners.created_at','>=',Carbon::today())->first();
        $winner=$is_winner;

        if(!$is_winner){        
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
            
            $winner=$winner->shuffle();
            
           
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
        }

        return response()->json([
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
        $liveQuizCorrectUser=LiveQuizCorrectUser::where('user_id',$request->user_id)->where('created_at','>=',Carbon::today())->first();

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
                $liveQuizCorrectUser->total_time=$request->time_taken;
                $liveQuizCorrectUser->save();
                return $liveQuizCorrectUser;
            }
        
            if(!$answerStatus){
                $liveQuizCorrectUser->prize=0;
                $liveQuizCorrectUser->point +=$livequiz->point;
                $liveQuizCorrectUser->total_time +=$livequiz->time;
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

        $livequizCorrectUser=LiveQuizCorrectUser::where('user_id',$request->user_id)->where('created_at','>=',Carbon::today())->first();
        $livequizzes=Livequiz::where('user_id',$request->user_id)->where('created_at','>=',Carbon::today())->get();
        $liveQuizUser=LiveQuizUser::where('user_id',$request->user_id)->where('created_at','>=',Carbon::today())->first();

        if($liveQuizUser){
            $liveQuizUser->delete();
        }
        if($livequizCorrectUser){
            $livequizCorrectUser->delete();
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

    public function setPosition(Request $request)
    {
        $position=Position::where('created_at','>=',Carbon::today())->first();
        if(!$position){
            $position=Position::create([
                'set'=>$request->question_set,
                'question_id'=>$request->question_id
            ]);
        }else{
            $position->question_id=$request->question_id;
            $position->update();
        }
        return $position;
    }

    public function getPosition()
    {
        $position=Position::where('created_at','>=',Carbon::today())->first();
        
        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Question Position',
            'data'=>$position
        ]);
    }

    public function getOptionCount(Request $request)
    {

        $totalLiveUsers=LiveQuizUser::where('created_at','>=',Carbon::today())->count();
        
        $options =\App\Option::where('question_id',$request->question_id)->get();
        $optionCount=[];

        foreach($options as $option){
            $optionCount[$option->name]=count(Livequiz::where('question_id',$request->question_id)->where('option',$option->name)
            ->where('created_at','>=',Carbon::today())->get());
        }

        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Options Count',
            'data'=>[
                'question_id'=>$request->question_id,
                'total_users'=>$totalLiveUsers,
                'correct_option'=>$options->where('answer',1)->pluck('name')->first(),
                'option_count'=>$optionCount
            ]
        ]);
    }

    public function registerLiveUsers(Request $request){
        $validator=LiveValidator::make($request->all(),[
            'user_id'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['status'=>false,'code'=>200,'message'=>'Validation Failed','data'=>'']);
        }
        $registerd_user= \App\LiveQuizUser::where('user_id',$request->user_id)->where('question_set',$request->question_set)
                                        ->where('created_at','>=',Carbon::today())->first();
        if($registerd_user)
        {
            return response()->json(['status'=>true,'code'=>200,'message'=>'Already Registerd','data'=>'']);
        }

        \App\LiveQuizUser::create([
            'user_id'=>$request->user_id,
            'question_set'=>$request->question_set
        ]);
        return response()->json(['status'=>true,'code'=>200,'message'=>'User registerd','data'=>'']);
    }

    public function getWinnerList(){
        $winners=Winner::leftJoin('users',function($join){
                        $join->on('winners.user_id','=','users.id');
                    })->orderBy('winners.created_at','desc')->get();
        
        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'all time winners list',
            'data'=>$winners,
        ]);
    }

}
