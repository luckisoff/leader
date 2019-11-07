<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Livequiz;
use App\LiveQuizCorrectUser;
use Illuminate\Support\Facades\Validator as LiveValidator;


class LivequizController extends Controller
{
    protected function index($question_id)
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
            'answer'=>'required',
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
        $livequiz->answer=$request->answer;
        $livequiz->time=$request->time;
        $livequiz->prize=$request->prize?$request->prize:'';
        $livequiz->point=$request->point?$request->point:'';
        $livequiz->save();

        $this->saveCorrectUserData($livequiz,$request);
        return $this->index($livequiz->question_id);
    }

    
    public function getWinner()
    {
        $winner='';
        
        $totalCorrectUsers=LiveQuizCorrectUser::where('created_at','>=',\Carbon\Carbon::today())->where('correct',1)->with('user')->orderBy('total_time','asc')->get();
        $totalFastestUsers=$totalCorrectUsers->groupBy('total_time')->first();
        if(count($totalFastestUsers)==1){
            $winner=$totalFastestUsers->first();
            $winner=$winner->user;
        }else{
            $users=[];
            foreach($totalFastestUsers as $user){
                $users[]=$user->user;
            }
            $winner=array_rand($users);
            $winner=$users[$winner];
        }
        $winnerData=LiveQuizCorrectUser::where('user_id',$winner->id)->where('created_at','>=',\Carbon\Carbon::today())->first();
        \App\Winner::create([
            'user_id'=>$winner->id,
            'question_set'=>$winnerData->question_set,
            'point'=>$winnerData->point,
            'prize'=>$winnerData->prize,
            'quiz_data'=>\Carbon\Carbon::parse($winnerData->created_at)
        ]);
        return $winner;
    }

    protected function saveCorrectUserData(Livequiz $livequiz,Request $request)
    {
        $liveQuizCorrectUser=LiveQuizCorrectUser::where('user_id',$livequiz->user_id)->first();
        if($livequiz->answer==1){
            if($liveQuizCorrectUser){
                $liveQuizCorrectUser->total_time +=$livequiz->time;
                $liveQuizCorrectUser->point +=$livequiz->point;
                $liveQuizCorrectUser->update();
            }else{
                LiveQuizCorrectUser::create([
                    'user_id'       =>$request->user_id,
                    'question_set'  =>$request->question_set,
                    'correct'       =>1,
                    'prize'         =>$request->prize?$request->prize:'',
                    'point'         =>$request->point?$request->point:'',
                    'total_time'    =>$request->time
                ]);
            }
        }else{
            if($liveQuizCorrectUser){
                $liveQuizCorrectUser->prize=0;
                $liveQuizCorrectUser->point +=$livequiz->point;
                $liveQuizCorrectUser->correct=0;
                $liveQuizCorrectUser->update();
            }
        }
    }

}
