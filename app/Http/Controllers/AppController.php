<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\App;
use Illuminate\Support\Facades\Validator;
class AppController extends Controller
{

    public function index(){
        $apps=App::orderBy('created_at','desc')->get();
        return view('admin.app.index')->with('apps' , $apps)->withPage('profile')->with('sub_page','');
    }

    public function create($id=''){
        $app='';
        if($id){
            $app=App::find($id);
        }
        return view('admin.app.create')->with('app' , $app)->withPage('profile')->with('sub_page','');
    }

    public function store(Request $request){
        $app='';
        $message='';
       if($request->has('id')){
         $app=App::find($request->id);
       }
       $this->validate($request,[
            'name'=>'required'
       ]);

       if(!is_null($app)){
            
            $app->name=$request->name;
            $app->status=$request->status;
            $app->save();
            $message=$app->status==1?$app->name.' is turned on!':$app->name.' is turned off!';
       }else{
           
            App::create([
                'name'=>$request->name,
                'status'=>$request->status
            ]);
            $message=$request->name.' is Created!';
       }
        return redirect()->route('app')->with('flash_success',tr($message));
    }


    public function destroy($id){
        $app=App::find($id);
        $app->delete();
        return redirect()->route('app')->with('flash_success',tr('An App is Deleted!'));
    }

    public function api(){
        $apps=App::orderBy('created_at','desc')->select('name','status as live')->get();
        return response()->json(['response'=>true,'type'=>'apps','data'=>$apps]);
    }
}
