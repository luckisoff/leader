<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Counter;
use Validator;
class CounterController extends Controller
{
    protected $editCounter='';
    public function __construct(){
        $this->middleware('admin');
    }
    
    
    public function index(){
        $counters = Counter::orderBy('created_at','DESC')->get();

        return view('admin.counter')->with('counters' , $counters)->withPage('counter')->with('sub_page','view-stories');
    }

    public function show($id=''){
        
        if(!empty($id)){
            $this->editCounter=Counter::findOrFail($id);
        }
        
        return view('admin.add-counter')->with('editCounter',$this->editCounter)->with('page' ,'')->with('sub_page' ,'');
    }

    public function store(Request $request,$id=''){
        
        if($id){
            $this->editCounter=Counter::findOrFail($id);
        }
        $validator=Validator::make($request->all(),array(
            'date'=>'required',
            'time'=>'required',
        ));

        if($validator->fails()){
            $error_messages = implode(',', $validator->messages()->all());
            return back()->with('flash_error', $error_messages);
        }

        if($this->editCounter!=''){
            $this->editCounter->name=$request->name;
            $this->editCounter->years=$request->date;
            $this->editCounter->months=$request->time;
            $this->editCounter->update();
            return redirect()->route('counter')->with('flash_success',tr('Counter Edited Successfully!'));
        }
        $counter=new Counter();
        $counter->name=$request->name;
        $counter->years=$request->date;
        $counter->months=$request->time;
        $counter->save();
        return redirect()->route('counter')->with('flash_success',tr('A Counter is created!'));
    }

    public function destroy($id){
        $counter=Counter::findOrFail($id);
        if($counter->delete()){
             return back()->with('flash_success',tr('Counter is deleted successfully!'));
        }
    }
}
