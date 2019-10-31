<?php

namespace App\Http\Controllers\Api;

use App\GundrukOfflineQuiz;
use App\Helpers\Helper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GundrukOfflineQuizController extends Controller
{
    public function addOfflineQuizPoint(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'point' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(Helper::setResponse('fail', 'missing_parameter', ''));
        }

        //checking user point if greater than 100
        if($request->point > 100){
            $offline_quiz = GundrukOfflineQuiz::where('user_id',$request->user_id)->first();

            if($offline_quiz != null){
                $offline_quiz->point = 0;
                $offline_quiz->save();
            }

            return response()->json(Helper::setResponse('fail', 'Error Cheating Detected', ''));
        }

        //insert or update
        $offline_quiz = GundrukOfflineQuiz::where('user_id',$request->user_id)->first();

        if($offline_quiz == null){
            //insert a new point to a new user.
            $offline_quiz = new GundrukOfflineQuiz();
            $offline_quiz->user_id = $request->user_id;
            $offline_quiz->point = $request->point;

            //if any life line used
            if(isset($request->options_used)){
                $request->options_used = 1;
            }
            $offline_quiz->save();

        }
        else{
            //update point of that user
            $offline_quiz = GundrukOfflineQuiz::where('user_id',$request->user_id)->first();

            //check also whether user has used all the option or not.    current max option is 4.
            if($offline_quiz->options_used > 4){
                return response()->json(Helper::setResponse('fail', 'You have already used your options', ''));

            }
            $offline_quiz->user_id = $request->user_id;
            $offline_quiz->point = $request->point + $offline_quiz->point;

            //if any life line used
            if(isset($request->options_used)){
                $request->options_used = $offline_quiz->options_used + 1;
            }
            $offline_quiz->save();
        }

        $responseData = Helper::setResponse('success', 'Point Added Successfully','');
        return response()->json($responseData);
    }

    public function get_logged_in_user_points(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(Helper::setResponse('fail', 'missing_parameter', ''));
        }

        $offline_quiz = GundrukOfflineQuiz::where('user_id',$request->user_id)->first();

        if($offline_quiz == null){
            return response()->json(Helper::setResponse('fail', 'User Has Not Played Quiz', ''));

        }

        $responseData = Helper::setResponse('success', 'User Point',$offline_quiz);
        return response()->json($responseData);

    }

    //showing users based on their point.
    public function getLeaderBoard(){

        $offline_quiz = GundrukOfflineQuiz::all();
        if(count($offline_quiz) == 0){
            return response()->json(Helper::setResponse('fail', 'No Data of Offline Quiz', ''));
        }

        //sending data based on high point and limiting by 20
        $offline_quiz = GundrukOfflineQuiz::limit(20)->orderby('point','desc')->with("user")->get();

        $data = [];
        $i = 1;
        foreach($offline_quiz as $value){

            $dat['rank'] = $i;
            $dat['point'] = $value->point;
            $dat['options_used'] = $value->options_used;
            $dat['amount'] = ($value->point/15);

            $dat['name'] = $value->user->name;
            $dat['picture'] = $value->user->picture;

            $i++;
            array_push($data,$dat);

        }

        $responseData = Helper::setResponse('success', 'User Point',$data);
        return response()->json($responseData);
    }
}
