<?php

namespace App\Http\Controllers\Api;

use App\Faq;
use App\Stories;
use App\Category;
use App\Helpers\Helper;
use App\Policy;
use App\Page;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
class GundrukController extends Controller
{
    public function getPolicy(){
        $policy = Policy::all();

        if(count($policy) == 0){
            $responseData = Helper::setResponse('fail','Policy  not found | Empty','','');
            return response()->json($responseData);
        }

        $responseData = Helper::setResponse('success','Policy Listing Successfull',$policy,'');
        return response()->json($responseData);
    }

    public function getPaymentTerms()
    {
        $page=Page::where('heading','payment_terms')->first();
        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Payment Terms',
            'data'=>$page
        ]);
    }
    public function getFaq(){
        $faq= Faq::all();

        if(count($faq) == 0){
            $responseData = Helper::setResponse('fail','FAQ  not found | Empty','','');
            return response()->json($responseData);
        }

        $responseData = Helper::setResponse('success','Policy Listing Successfull',$faq,'');
        return response()->json($responseData);
    }
    
    public function getStoriesList(){
        
        //respond the categories with story created today/last 24 hrs
        $categories=Category::with(['story'=>function($q){
            $q->where('updated_at','>=',\Carbon\Carbon::now()->subDay());
        }])->whereHas('story',function($q){
            $q->where('updated_at','>=',\Carbon\Carbon::now()->subDay());
        })->orderBy('updated_at','desc')->get();

        $categories=Category::with('story')->orderBy('updated_at','desc')->get();
    
        return response()->json($categories);
        
        // $stories= Stories::with('category')->where('created_at', '>=', Carbon::now()->subDay())->get();
        
        
        
        // if(count($stories) == 0){
        //     $responseData = Helper::setResponse('fail','Stories  not found | Empty','','');
        // }
        
        // $newstories = array();
        // foreach ($stories as $key => $story) {
            
           
            
        //     if (isset($newstories[$story->name])) {
        //         $newstories[$story->name]['profile_picture'] = $story->category->picture;
                
        //         $newstories[$story->category->name]['stories'][$key]['picture'] = $story->picture;
        //         $newstories[$story->category->name]['stories'][$key]['id'] = $story->id;
                
            
        //         $newstories[$story->category->name]['stories'][$key]['created_at'] = $story->created_at;
                
                
                
        //         $newstories[$story->name]['stories'][$key]['updated_at'] = $story->updated_at;
        //     } else {
        //         $newstories[$story->category->name]['profile_picture'] = $story->category->picture;
        //         $newstories[$story->category->name]['stories'][$key]['picture'] = $story->picture;
        //         $newstories[$story->category->name]['stories'][$key]['id'] = $story->id;
        //         $newstories[$story->category->name]['stories'][$key]['created_at'] = $story->created_at;
                
                
                
        //         $newstories[$story->category->name]['stories'][$key]['updated_at'] = $story->updated_at;
        //     }
        // }

        // $responseData = Helper::setResponse('success','Stories Listing Successfull',$newstories,'');
        
        
        // return response()->json($responseData);
        
    }
    
    
    public function getVideosList(){
        $videos=\App\AdminVideo::select('admin_videos.default_image','admin_videos.video')->orderBy('created_at','DESC')->get();
        return response()->json($videos);
    }
    
     public function getCounter(){
        $counters=\App\Counter::where('years','>=',\Carbon\Carbon::now())->orderBy('created_at','DESC')->get();
        $count=array();
        foreach($counters as $counter){
            $leftTime=\Carbon\Carbon::parse($counter->years.' '.$counter->months);
            
            $today=\Carbon\Carbon::now();
            
            $count[]=array(
                'counterName'=>$counter->name,
                'CounterDate'=>$counter->years,
                'years'=>$leftTime->diffInYears($today),
                'months'=>$leftTime->diffInMonths($today),
                'days'=>$leftTime->diffInDays($today),
                'hours'=>$leftTime->diffInHours($today),
                'minutes'=>$leftTime->diffInMinutes($today),
                'seconds'=>$leftTime->diffInSeconds($today),
                'milliseconds'=>$leftTime->diffInMilliseconds($today)
                );
        }
        return response()->json($count);
    }

}
