<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Mirai;
use Illuminate\Support\Facades\Validator;

class MiraiController extends Controller
{
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),[
                'name'  =>'required',
                'address'  =>'required',
                'email'  =>'required',
                'phone'  =>'required',
                'qualification'  =>'required',
                'country'  =>'required',
                'ielts'  =>'required'
            ]);

            if($validator->fails()) throw new \Exception($validator->errors()->first(),403);
            
            $mirai = Mirai::create($request->all());

            return response()->json([
                'status'    =>true,
                'code'      =>200,
                'message'   =>'Stored successfully',
                'data'    =>$mirai
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status'    =>false,
                'code'      =>$th->getCode(),
                'message'   =>$th->getMessage()
            ],$th->getCode());
        }
    }
}
