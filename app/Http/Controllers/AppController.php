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

    public function create($app=''){
        return view('admin.app.create')->with('app' , $app)->withPage('profile')->with('sub_page','');
    }

    public function store(Request $request){
       
       $this->validate($request,[
            'name'=>'required'
       ]);
        App::create([
            'name'=>$request->name,
            'status'=>$request->status
        ]);
        return redirect()->route('app')->with('flash_success',tr('An App is Created!'));
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
