<?php

namespace App\Http\Controllers;

use App\Audition;
use App\Banner;
use App\Helpers\Helper;
use App\Judge;
use App\Location;
use App\News;
use App\Sponser;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Redirect;


class AuditionController extends Controller
{
    // news crud here
    public function viewNews(){
        $data['news'] = News::all();
        $data['page'] = 'news';
        $data['sub_page'] = 'show_news';
//        dd($data);

        return view('admin.news.view-news',$data);
    }

    public function showNewsForm(){
        return view('admin.news.add-news')
            ->with('page' , 'news')
            ->with('sub_page',"add_news");
    }

    public function addNews(Request $request){
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:2058',
        ]);

        //validating video link url if it is filled in form
        if(isset($request->video)){
            $this->validate($request, [
                'video' => 'required|mimes:mp4,3gp,flv,m3u8,ts,mov,avi,wmv'
            ]);
        }

        $news = new News();

        $news->title = $request->title;
        $news->description = $request->description;
        $news->image = Helper::normal_img_upload($request->file('image'),'/uploads/audition/news');
        $news->created_at = date('Y-m-d H:i:s');
        $news->created_by = \Auth::guard('admin')->user()->id;

        if(isset($request->video)){
            $news->video = Helper::normal_img_upload($request->file('video'),'/uploads/audition/news');
        }


        $news->save();

        \Session::flash('flash_success','News Added Successfully');
        return redirect()->route('news.view-news');
    }

    public function  showEditNewsForm($id){
        $data['news'] = News::find($id);
        if($data['news'] == null){
            \Session::flash('flash_error','Error While Editing Banner Information');
            return redirect()->route('news.view-news');
        }
        $data['page'] = 'news';
        return view('admin.news.edit-news',$data);
    }

    public function editNews(Request $request){
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'news_id' => 'required',
        ]);

        //validating video link url if it is filled in form
        if(isset($request->image)){
            $this->validate($request, [
                'image' => 'required|mimes:jpeg,png,jpg,gif|max:2058',
            ]);
        }

        if(isset($request->video)){
            $this->validate($request, [
                'video' => 'required|mimes:mp4,3gp,flv,m3u8,ts,mov,avi,wmv'
            ]);
        }

        $news = News::find($request->news_id);

        $news->title = $request->title;
        $news->description = $request->description;

        if(isset($request->image)){
            File::delete( base_path() . "/uploads/audition/news/" . basename($news->image));
            $news->image = Helper::normal_img_upload($request->file('image'),'/uploads/audition/news');
        }

        if(isset($request->video)){
            File::delete( base_path() . "/uploads/audition/news/" . basename($news->video));
            $news->video = Helper::normal_img_upload($request->file('video'),'/uploads/audition/news');
        }
        $news->created_at = date('Y-m-d H:i:s');
        $news->created_by = \Auth::guard('admin')->user()->id;

        $news->save();

        \Session::flash('flash_success','News Updated Successfully');
        return redirect()->route('news.view-news');
    }

    public function deleteNews($id){
        $data = News::find($id);
        if($data == null){
            \Session::flash('flash_error','Error While Deleting Banner');
            return redirect()->route('news.view-news');
        }

        File::delete( base_path() . "/uploads/audition/news/" . basename($data->image));

        if($data->video != null){
            File::delete( base_path() . "/uploads/audition/news/" . basename($data->video));
        }

        $data->delete();

        \Session::flash('flash_success','News Deleted Successfully');
        return redirect()->route('news.view-news');
    }



    //function for audition banner started from here crud opearation
    public function viewBanner(){
//        $data['banner'] = Banner::all();

        $data['banner'] = Banner::all();
        $data['page'] = 'banner';
        $data['sub_page'] = 'show_banner';
//        dd($data);

        return view('admin.banner.view-banner',$data);
    }

    public function showBannerForm(){
        return view('admin.banner.add-banner')
            ->with('page' , 'banner')
            ->with('sub_page',"add_banner");
    }

    public function addBanner(Request $request){
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        //validating the form field.
        $this->validate($request, [
            'banner_link' => 'required|regex:'.$regex,
            'instruction' => 'required|max:255',
            'image' => 'required|mimes:jpeg,png,jpg,gif',
        ]);

        //validating video link url if it is filled in form
        /*if(isset($request->video_link)){
            $this->validate($request, [
                'video_link' => 'regex:'.$regex,
            ]);
        }*/

        $banner = new Banner();

        $banner->banner_link = $request->banner_link;
        $banner->video_link = $request->video_link;

        $banner->instruction = $request->instruction;
        $banner->image = Helper::normal_img_upload($request->file('image'),'/uploads/audition/banner');


        $banner->save();

        \Session::flash('flash_success','Banner Added Successfully');
        return redirect()->route('banner.view-banner');
    }

    public function  showEditBannerForm($id){
        $data['banner'] = Banner::find($id);
        if($data['banner'] == null){
            \Session::flash('flash_error','Error While Editing Banner Information');
            return redirect()->route('banner.view-banner');
        }
        $data['page'] = 'banner';
        return view('admin.banner.edit-banner',$data);
    }

    public function editBanner(Request $request){
//        dd($request->all());
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        //validating the form field.
        $this->validate($request, [
            'banner_id' => 'required',
            'banner_link' => 'required|regex:'.$regex,
            'instruction' => 'required|max:255',
        ]);

        //validating video link url if it is filled in form
        /*if(isset($request->video_link)){
            $this->validate($request, [
                'video_link' => 'regex:'.$regex,
            ]);
        }*/

        if(isset($request->image)){
            $this->validate($request, [
                'image' => 'required|mimes:jpeg,png,jpg,gif',
            ]);
        }

        $banner =  Banner::find($request->banner_id);

        $banner->banner_link = $request->banner_link;
        $banner->video_link = $request->video_link;

        $banner->instruction = $request->instruction;

        if(isset($request->image)){
            File::delete( base_path() . "/uploads/audition/banner/" . basename($banner->image));
            $banner->image = Helper::normal_img_upload($request->file('image'),'/uploads/audition/banner');
        }


        $banner->save();

        \Session::flash('flash_success','Banner Updated Successfully');
        return redirect()->route('banner.view-banner');
    }

    public function deleteBanner($id){
        $data = Banner::find($id);
        if($data == null){
            \Session::flash('flash_error','Error While Deleting Banner');
            return redirect()->route('banner.view-banner');
        }

        File::delete( base_path() . "/uploads/audition/banner/" . basename($data->image));
        $data->delete();

        \Session::flash('flash_success','Banner Deleted Successfully');
        return redirect()->route('banner.view-banner');
    }

    //end banner function

    //started sponser function
    public function showSponserForm(){
        return view('admin.sponser.add-sponser')
            ->with('page' , 'sponser')
            ->with('sub_page',"add_sponser");
    }

    public function addSponser(Request $request){
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        //validating the form field.
        $this->validate($request, [
            'link' => 'required|max:255|regex:'.$regex,
            'name' => 'required|max:50',
            'partner_type' => 'required|max:100',
            'image' => 'required|mimes:jpeg,png,jpg,gif',
        ]);

        $sponser = new Sponser();

        $sponser->name = $request->name;
        $sponser->partner_type  = $request->partner_type;

        $sponser->link = $request->link;
        $sponser->image = Helper::normal_img_upload($request->file('image'),'/uploads/audition/sponser');


        $sponser->save();

        \Session::flash('flash_success','Sponser Added Successfully');
        return redirect()->route('sponser.view-sponser');
    }

    public function viewSponser(){
        $data['sponser'] = Sponser::all();
        $data['page'] = 'sponser';
        $data['sub_page'] = 'show_sponser';
//        dd($data);

        return view('admin.sponser.view-sponser',$data);

    }

    public function  showEditSponserForm($id){
        $data['sponser'] = Sponser::find($id);

        if($data['sponser'] == null){
            \Session::flash('flash_error','Error While Editing Sponser Information');
            return redirect()->route('sponser.view-sponser');
        }

        $data['page'] = 'sponser';
        return view('admin.sponser.edit-sponser',$data);
    }

    public function editSponser(Request $request){
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        //validating the form field.
        $this->validate($request, [
            'sponser_id' => 'required',
            'link' => 'required|max:255|regex:'.$regex,
            'name' => 'required|max:50',
            'partner_type' => 'required|max:100',
        ]);

        if(isset($request->image)){
            $this->validate($request, [
                'image' => 'required|mimes:jpeg,png,jpg,gif',
            ]);
        }

        $sponser = Sponser::find($request->sponser_id);

        $sponser->name = $request->name;
        $sponser->partner_type  = $request->partner_type;

        $sponser->link = $request->link;

        if(isset($request->image)) {
            File::delete( base_path() . "/uploads/audition/sponser/" . basename($sponser->image));
            $sponser->image = Helper::normal_img_upload($request->file('image'), '/uploads/audition/sponser');
        }

        $sponser->save();

        \Session::flash('flash_success','Sponser Updated Successfully');
        return redirect()->route('sponser.view-sponser');
    }

    public function deleteSponser($id){
        $data = Sponser::find($id);
        if($data == null){
            \Session::flash('flash_error','Error While Deleting Sponser');
            return redirect()->route('sponser.view-sponser');
        }

        File::delete( base_path() . "/uploads/audition/sponser/" . basename($data->image));
        $data->delete();

        \Session::flash('flash_success','Sponser Deleted Successfully');
        return redirect()->route('sponser.view-sponser');
    }

    //end sponser function

    //start judge function
    public function viewJudge(){
        $data['judge'] = Judge::all();
        $data['page'] = 'judge';
        $data['sub_page'] = 'show_judge';

        return view('admin.judge.view-judge',$data);
    }

    public function showJudgeForm(){
        return view('admin.judge.add-judge')
            ->with('page' , 'judge')
            ->with('sub_page',"add_judge");
    }
    public function addJudge(Request $request){
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $this->validate($request, [
            'name' => 'required|max:100',
            'judge_image' => 'required|mimes:jpeg,png,jpg,gif',
            'description'=>'required'
        ]);

        if(!empty($request->insta_link)){
            $this->validate($request, [
                'insta_link' => 'required|max:255|regex:'.$regex,
            ]);
        }

        if(!empty($request->fb_link)){
            $this->validate($request, [
                'fb_link' => 'required|max:255|regex:'.$regex,
            ]);

        }

        if(!empty($request->twitter_link)){
            $this->validate($request, [
                'twitter_link' => 'required|max:255|regex:'.$regex,
            ]);
        }

        if(!empty($request->youtube_link)){
            $this->validate($request, [
                'youtube_link' => 'required|max:255|regex:'.$regex,
            ]);
        }

        $judge = new Judge();

        $judge->name = $request->name;
        $judge->insta_link = $request->insta_link;
        $judge->fb_link = $request->fb_link;
        $judge->twitter_link = $request->twitter_link;
        $judge->youtube_link=$request->youtube_link;
        $judge->description=$request->description;
        $judge->type=$request->type;
        $judge->image = Helper::normal_img_upload($request->file('judge_image'),'/uploads/audition/judge');

        $judge->save();

        \Session::flash('flash_success','Judge Added Successfully');
        return redirect()->route('judge.view-judge');
    }

    public function  showEditJudgeForm($id){
        $data['judge'] = Judge::find($id);

        if($data['judge'] == null){
            \Session::flash('flash_error','Error While Editing Judge Information');
            return redirect()->route('judge.view-judge');
        }

        $data['page'] = 'judge';
        return view('admin.judge.edit-judge',$data);
    }

    public function editJudge(Request $request){
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $this->validate($request, [
            'judge_id' => 'required',
            'name' => 'required|max:100',
        ]);

        if(!empty($request->insta_link)){
            $this->validate($request, [
                'insta_link' => 'required|max:255|regex:'.$regex,
            ]);
        }

        if(!empty($request->fb_link)){
            $this->validate($request, [
                'fb_link' => 'required|max:255|regex:'.$regex,
            ]);

        }

        if(!empty($request->twitter_link)){
            $this->validate($request, [
                'twitter_link' => 'required|max:255|regex:'.$regex,
            ]);
        }

        if(isset($request->judge_image)){
            $this->validate($request, [
                'judge_image' => 'required|mimes:jpeg,png,jpg,gif',
            ]);
        }

        $judge = Judge::find($request->judge_id);

        $judge->name = $request->name;
        $judge->insta_link = $request->insta_link;
        $judge->fb_link = $request->fb_link;
        $judge->twitter_link = $request->twitter_link;
        $judge->type=$request->type;
        $judge->description=$request->description;

        if(isset($request->judge_image)){
            File::delete( base_path() . "/uploads/audition/judge/" . basename($judge->image));
            $judge->image = Helper::normal_img_upload($request->file('judge_image'),'/uploads/audition/judge');
        }

        $judge->save();

        \Session::flash('flash_success','Judge Updated Successfully');
        return redirect()->route('judge.view-judge');
    }

    public function deleteJudge($id){

        $data = Judge::find($id);
        if($data == null){
            \Session::flash('flash_error','Error While Deleting Judge');
            return redirect()->route('judge.view-judge');
        }

        File::delete( base_path() . "/uploads/audition/judge/" . basename($data->image));
        $data->delete();

        \Session::flash('flash_success','Judge Deleted Successfully');
        return redirect()->route('judge.view-judge');
    }
    //end judge function

    //start audition registration
    public function showAuditionForm(){
        return view('admin.audition.add-audition')
            ->with('page' , 'audition')
            ->with('sub_page',"add_audition");
    }

    public function addAudition(Request $request){

        $this->validate($request, [
            'crsf' => 'required',
            'name' => 'required|max:50',
            'gender' => 'required|max:50',
            'address' => 'required|max:50',
            'number' => 'required|max:15',
            'email' => 'required|email|max:100',
        ]);

        if(isset($request->image)){
            $this->validate($request, [
                'image' => 'required|mimes:jpeg,png,jpg,gif',

            ]);
        }

        $form = new Audition();
        $form->user_id = 0;
        $form->name = $request->name;
        $form->gender = $request->gender;
        $form->address = $request->address;

        $form->number = $request->number;
        $form->email = $request->email;

//        $form->attachment = Helper::normal_img_upload($request->file('attachment'),'/uploads/audition/attachment');


        if(isset($request->image)){
            $form->image = Helper::normal_img_upload($request->file('image'),'/uploads/audition/document');

        }
        $form->save();

        \Session::flash('flash_success','New Contestant Registered  Successfully');
        return redirect()->route('audition.view-audition');
    }

    public function viewAllAuditionUser(){
        $data['totalUsers'] =Audition::count();
        $data['totalRegistered']=Audition::where('payment_status',1)->count();
        $data['esewaUsers']=Audition::where('payment_type','Esewa')->orWhere('payment_type','esewa')->count();        
        $data['khaltiUsers']=Audition::where('payment_type','Khalti')->orWhere('payment_type','khalti')->count();        
        $data['paypalUsers']=Audition::where('payment_type','Paypal')->orWhere('payment_type','paypal')->count();        
        $data['page'] = 'audition';
        $data['sub_page'] = 'show_audition';

        return view('admin.audition.view-audition',$data);

    }

    public function  showEditAuditionForm($id){
        $data['contestant'] = Audition::find($id);
        if($data['contestant'] == null){
            \Session::flash('flash_error','Error While Editing Contestant Information');
            return redirect()->route('audition.view-audition');
        }
        $data['page'] = 'Edit Contestant';
        return view('admin.audition.edit-audition',$data);
    }

    public function editAudition(Request $request){
        $this->validate($request, [
            'contestant_id' => 'required',
            'crsf' => 'required',
            'name' => 'required|max:50',
            'gender' => 'required|max:50',
            'address' => 'required|max:50',
            'number' => 'required|max:15',
            'email' => 'required|email|max:100',
        ]);

        if(isset($request->image)){
            $this->validate($request, [
                'image' => 'required|mimes:jpeg,png,jpg,gif',

            ]);
        }
        $form =  Audition::find($request->contestant_id);

        $form->name = $request->name;
        $form->gender = $request->gender;
        $form->address = $request->address;
        $form->payment_status=$request->payment_status;

        $form->payment_type=$form->payment_status==1?$request->payment_type:'';
        $form->registration_code=$form->payment_status==1?'LEADERSRBN'.$form->user_id:'';
        
        $form->number = $request->number;
        $form->email = $request->email;

        if(isset($request->image)){
            File::delete( base_path() . "/uploads/audition/document/" . basename($form->image));
            $form->image = Helper::normal_img_upload($request->file('image'),'/uploads/audition/document');

        }

        /*if(isset($request->attachment)){
            File::delete( base_path() . "/uploads/audition/attachment/" . basename($form->attachment));
            $form->attachment = Helper::normal_img_upload($request->file('attachment'),'/uploads/audition/attachment');

        }*/
        $form->save();

        \Session::flash('flash_success','Contestant Updated Successfully');
        return redirect()->route('audition.view-audition');
    }

    public function deleteAudition($id){
        $data = Audition::find($id);
        if($data == null){
            \Session::flash('flash_error','Error While Deleting Contestant Information');
            return redirect()->route('audition.view-audition');
        }

//        File::delete( base_path() . "/uploads/audition/document/" . basename($data->image));
//        File::delete( base_path() . "/uploads/audition/attachment/" . basename($data->attachment));
        $data->delete();

        \Session::flash('flash_success','Contestant Deleted Successfully');
        return redirect()->route('audition.view-audition');
    }

    //khalti integration
    public function showKhalti(){
        if(isset($_GET['user_id']) || isset($_GET['user_type'])){
            if($_GET['user_type'] == 'admin'){
                $data['user_id'] = $_GET['user_id'];
                $data['user_type'] = 'admin';
                $data['page'] = 'audition';
                $data['sub_page'] = 'show_audition';
                return view('admin.audition.khalti',$data);
            }
            else{
                $data['user_id'] = $_GET['user_id'];
                $data['user_type'] = 'user';

                $data['page'] = 'khalti';
                $data['sub_page'] = '';
                return view('khalti',$data);
            }

        }
        else{
            abort('404');
        }


    }

    public function integrateKhalti(){
        $args = http_build_query(array(
            'token' => $_GET['token'],
            'amount'  => $_GET['amount']
        ));

        $user_id = $_GET['user_id'];
        $user_type = $_GET['user_type'];


        $url = "https://khalti.com/api/v2/payment/verify/";

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = ['Authorization: Key test_secret_key_cf070a6ab7814f6b8cd32294d3f865f0'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if($status_code == 200){
            //after success change user payment to 1 i.e verified
            $audition = Audition::find($user_id);
            $audition->payment_type = "Khalti";
            $audition->payment_status = 1;
            $audition->save();

            if($user_type == "user"){
                return Redirect::to('http://localhost/bharyang/audition/payment?user_id='.$_GET['user_id'].'&payment=success');
                return view('payment',$data);

            }
            else
            {
                \Session::flash('flash_success','Khalti Payment Successfully');
                return redirect()->route('audition.view-audition');
            }

        }
        else{
            if($user_type == "user"){
                return Redirect::to('http://localhost/bharyang/audition/payment?user_id='.$_GET['user_id'].'&payment=fail');
            }
            else
            {
                \Session::flash('flash_error','Error on Khalti Payment. Please Try Again');
                return redirect()->route('audition.view-audition');
            }
            }





    }
    //end audition registration

    //start audition location function
    public function viewAllAuditionLocation(){
        $data['location'] = Location::all();
        $data['page'] = 'location';
        $data['sub_page'] = 'show_location';

        return view('admin.location.view-location',$data);
    }

    public function showAuditionLocationForm(){
        return view('admin.location.add-location')
            ->with('page' , 'location')
            ->with('sub_page',"add_location");
    }
    public function addLocation(Request $request){

        $this->validate($request, [
            'location' => 'required|max:100',
            'venue' => 'required|max:100',
            'landmark' => 'required|max:100',
        ]);

        if(!empty($request->latitude)){
            $this->validate($request,[
                'latitude' => 'numeric|between:0,999.99'
            ]);
        }

        if(!empty($request->longitude)){
            $this->validate($request,[
                'longitude' => 'numeric|between:0,999.99'

            ]);
        }
        $location = new Location();

        $location->location = $request->location;
        $location->venue = $request->venue;
        $location->landmark = $request->landmark;
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->type=$request->type;
        $location->image = Helper::normal_img_upload($request->file('image'),'/uploads/audition/judge');
        $location->save();

        \Session::flash('flash_success','Location Added Successfully');
        return redirect()->route('location.view-location');
    }

    public function deleteLocation($id){
        $data = Location::find($id);
        if($data == null){
            \Session::flash('flash_error','Error While Deleting Audition Location');
            return redirect()->route('location.view-location');
        }

        $data->delete();

        \Session::flash('flash_success','Location Deleted Successfully');
        return redirect()->route('location.view-location');
    }

    public function showEditLocationForm($id){
        $data['location'] = Location::find($id);
        if($data['location'] == null){
            \Session::flash('flash_error','Error While Editing Location');
            return redirect()->route('location.view-location');
        }
        $data['page'] = 'location';
        return view('admin.location.edit-location',$data);
    }

    public function editLocation(Request $request){
        $this->validate($request, [
            'location' => 'required|max:100',
            'venue' => 'required|max:100',
            'landmark' => 'required|max:100',
        ]);

        if(!empty($request->latitude)){
            $this->validate($request,[
                'latitude' => 'numeric|between:0,999.99'
            ]);
        }

        if(!empty($request->longitude)){
            $this->validate($request,[
                'longitude' => 'numeric|between:0,999.99'

            ]);
        }

        $location = Location::find($request->location_id);

        $location->location = $request->location;
        $location->venue = $request->venue;
        $location->landmark = $request->landmark;
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->type = $request->type;
        $location->country = $request->country;
        $location->city = $request->city;
        if(isset($request->image)){
            if($location->image!=null)
            {
                File::delete( base_path() . "/uploads/audition/judge/" . basename($location->image));
            }
            $location->image = Helper::normal_img_upload($request->file('image'),'/uploads/audition/judge');
        }
        $location->save();

        \Session::flash('flash_success','Location Updated Successfully');
        return redirect()->route('location.view-location');
    }
    //end audition location function




    public function ajax(Request $request)
    {
        $columns = array( 
            0 =>'id', 
            1=>'user_id',
            2 =>'name',
            3=> 'number',
            4=> 'address',
            5=> 'gender',
            6=>'email',
            7=>'payment_status',
            8=>'registration_code',
            9=>'payment_type'
        );

        $totalData = Audition::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $auditions = Audition::offset($start)
                ->limit($limit)
                ->orderBy('payment_status','desc')
                ->get();
        }
        else 
        {
            $search = $request->input('search.value'); 

            $auditions =  Audition::where('user_id','LIKE',"%{$search}%")
                        ->orWhere('name', 'LIKE',"%{$search}%")
                        ->orWhere('address','LIKE',"%{$search}%")
                        ->offset($start)
                        ->orWhere('payment_type','LIKE',"%{$search}%")
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = Audition::where('user_id','LIKE',"%{$search}%")
                    ->orWhere('name', 'LIKE',"%{$search}%")
                    ->orWhere('address', 'LIKE',"%{$search}%")
                    ->orWhere('payment_type','LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($auditions))
        {
            foreach ($auditions as $key=>$audition)
            {
                
                $nestedData['id'] = $key+1+$start;
                $nestedData['user_id'] = $audition->payment_status==1
                ?"<span class='label label-success'>".$audition->user_id."<span>":
                "<span class='label label-danger'>".$audition->user_id."<span>";


                $nestedData['name'] = $audition->name;
                $nestedData['number'] =$audition->number;
                $nestedData['address'] =$audition->address;
                $nestedData['gender'] =$audition->gender;
                $nestedData['email'] =$audition->email;

                $nestedData['payment_status'] =$audition->payment_status==1
                ?"<i style='color:green;padding-left:25px;' class='fa fa-check-circle'></i>":
                "<i style='color:red;padding-left:25px;' class='fa fa-times-circle'></i>";

                $nestedData['payment_type'] =$this->ajaxPaymentType($audition->payment_type);
                $nestedData['registration_code'] =$audition->registration_code
                ?"<span class='label label-success'>".$audition->registration_code."</span>":"<span class='label label-danger'>Unavailable</span>";
                
                $nestedData['options'] =$this->ajaxOption($audition); 
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );
        return json_encode($json_data);
    }

    protected function ajaxOption($option)
    {
        return 
        '<ul class="admin-action btn btn-default">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    Action <span class="caret"></span>
                </a>

                <ul class="dropdown-menu">

                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href='.route('audition.edit-audition-form', array('id' => $option->id)).'>
                            <i class="fa fa-pencil"></i>Edit
                        </a>
                    </li>


                    <li role="presentation">
                        
                            <a role="menuitem" tabindex="-1" onclick="return confirm("Are you sure?");" href='.route("audition.delete-audition",array("id" => $option->id)).'>
                                <i class="fa fa-trash"></i>Delete
                            </a>
                    </li>
                </ul>
            </li>
        </ul>';
    }

    protected function ajaxPaymentType($type){
        $message='';
        switch(strtolower($type)){
            case 'khalti':
                $message=
                '<div style="text-align:-webkit-center;">
                    <img title="Khalti" class="img img-responsive" style="width:52px" src="'.asset('images/khalti.png').'" alt="Pay With Khalti">
                </div>';
            break;
            case 'esewa':
                $message=
                '<div style="text-align:-webkit-center;">
                    <img title="Esewa" class="img img-responsive" style="width:52px" src="'.asset('images/esewa-logo.jpg').'" alt="Pay With Khalti">
                </div>';
            break;
            case 'paypal':
                $message=
                '<div style="text-align:-webkit-center;">
                    <img title="Paypal" class="img img-responsive" style="width:85%;" src="'.asset('images/paypal.png').'" alt="Pay With Khalti">
                </div>';
            break;
            default:
            $message='Not Available';
        }
        return $message;
    }
}
