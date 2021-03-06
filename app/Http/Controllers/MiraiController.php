<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Mirai;
use Illuminate\Support\Facades\Validator;
use App\Audition;

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

    public function excel($status=1)
    {
        try {
            
            $auditions = Audition::where('payment_status',$status)->select(
                'name as Name','address as Address','email as Email','number as Phone','gender as Gender','registration_code as Reg-Code'
            )->orderBy('address','asc')->get()->toArray();
    
            $filename = ($status?'reg':'unreg')."_audition_data_" . date('Ymd') . ".xls";
    
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: application/vnd.ms-excel");
            
            $flag = false;
    
            foreach($auditions as $audition)
            {
                if(!$flag) 
                {
                    echo implode("\t", array_keys($audition)) . "\r\n";
                    $flag = true;
                }
    
                echo implode("\t", array_values($audition)) . "\r\n";
            }
    
            return ['Total Audition'=>count($auditions)];

        } catch (\Throwable $th) {
            return ['error'=>$th->getMessage()];
        }
    }
}
