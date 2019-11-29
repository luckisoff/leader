<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SpinnerLandmark;
class SpinnerController extends Controller
{
    public function index(){
        $spinnerLandmarks=SpinnerLandmark::orderBy('created_at','desc')->get();
        return view('admin.spinner.index')->with('spinners' , $spinnerLandmarks)->withPage('profile')->with('sub_page','');
    }

    public function create(){
        return view('admin.spinner.create')->withPage('profile')->with('sub_page','');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'point'=>'required',
            'price'=>'required'
        ]);

        SpinnerLandmark::create([
            'point'=>$request->point,
            'price'=>$request->price
        ]);
        return redirect()->route('landmark')->with('flash_success',tr('A Landmark is created!'));
    }

    public function destroy($spinnerLandmark)
    {
        $spinnerLandmark=SpinnerLandmark::find($spinnerLandmark);
        $spinnerLandmark->delete();
        return redirect()->route('landmark')->with('flash_success',tr('A Landmark is deleted!'));
    }
}
