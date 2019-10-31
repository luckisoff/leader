<?php

namespace App\Http\Controllers\Api;

use App\Audition;
use App\Banner;
use App\Helpers\Helper;
use App\Judge;
use App\Location;
use App\News;
use App\Sponser;
use App\Policy;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuditionController extends Controller
{

    //audition form function here
    public function storeAuditionForm(Request $request){
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'number' => 'required|max:20',
            'gender' => 'required|max:255',
            'email' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return Helper::setResponse(true, 'missing_parameter', '');
        }

        if(isset($request->image)){
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpeg,png,jpg,gif',
            ]);

            if ($validator->fails()) {
                return Helper::setResponse(true, 'Image Format support only jpeg png jpg and gif ', '');
            }
        }
        //check whether the user has already submit the form.
        $audition = Audition::where('user_id',$request->user_id)->first();

        if($audition != null){
            return Helper::setResponse(true, 'You have already submit the form ', '');

        }

        //insert into table

        $form = new Audition();
        $form->user_id = $request->user_id;
        $form->name = $request->name;
        $form->address = $request->address;
        $form->number = $request->number;

        $form->gender = $request->gender;
        $form->email = $request->email;
        $form->created_at = date('Y-m-d H:i:s');

        if(isset($request->image)){
            $form->image = Helper::normal_img_upload($request->file('image'),'/uploads/audition/document');

        }
        $form->save();

        $responseData = Helper::setResponse(false, 'User Registered Successfully','');
        return response()->json($responseData);
    }


    //audition form payment status
    public function getAuditionStatus(){
        if(isset($_GET['user_id'])){
            $user_id = $_GET['user_id'];
            $audition = Audition::where('user_id',$user_id)->first();

            if($audition == null){
                $responseData = Helper::setResponse('fail','User Has Not Submit Form','','');
            }
            else{
                $responseData = Helper::setResponse('success','Payment Information Listing Successfull',$audition,'');
            }

            return response()->json($responseData);

        }
        else{
            $responseData = Helper::setResponse('fail','Parameter Missing','','');
            return response()->json($responseData);
        }


    }

    //banner listing
    public function getBannerlist(){
        $banner = Banner::all();

        if(count($banner) == 0){
            $responseData = Helper::setResponse('fail','Banner not found | Empty','','');
            return response()->json($responseData);
        }

        $responseData = Helper::setResponse('success','Banner Listing Successfull',$banner,'');
        return response()->json($responseData);
    }

    //judge listing
    public function getJudgelist(){
        $judge = Judge::all();

        if(count($judge) == 0){
            $responseData = Helper::setResponse('fail','Judge not found | Empty','','');
            return response()->json($responseData);
        }

        $responseData = Helper::setResponse('success','Judge Listing Successfull',$judge,'');
        return response()->json($responseData);
    }

    //sponser listing
    public function getSponserlist(){
        $sponser = Sponser::all();


        if(count($sponser) == 0){
            $responseData = Helper::setResponse('fail','Sponser not found | Empty','','');
            return response()->json($responseData);
        }

        $responseData = Helper::setResponse('success','Sponser Listing Successfull',$sponser,'');
        return response()->json($responseData);
    }

    //location listing
    public function getLocationlist(){
        $location = Location::all();

        if(count($location) == 0){
            $responseData = Helper::setResponse('fail','Location not found | Empty','','');
            return response()->json($responseData);
        }

        $responseData = Helper::setResponse('success','Location Listing Successfull',$location,'');
        return response()->json($responseData);
    }

    //news listing
    public function getNewslist(){
        $news = News::all();

        if(count($news) == 0){
            $responseData = Helper::setResponse('fail','News  not found | Empty','','');
            return response()->json($responseData);
        }

        $responseData = Helper::setResponse('success','News Listing Successfull',$news,'');
        return response()->json($responseData);
    }



}
