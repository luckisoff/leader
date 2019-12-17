<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function showRegister()
    {
        return view('admin.auth.register')->with('page','');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|unique:admins',
            'password'=>'required|min:8|confirmed'
        ]);

        if(Admin::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'is_activated'=>$request->is_activated
        ]))
        {
            return redirect('/admin/view')->with('flash_success','New admin added successfully.');
        }
        return redirect('/admin/new/register')->with('flash_error','Not able to insert new admin.');
    }

    public function view()
    {
        $users=Admin::orderBy('created_at','desc')->get();
        return view('admin.auth.view')->with('users',$users)->with('page','');
    }

    public function destroy($id)
    {

        if(Admin::find($id)->delete())
        {
            return redirect()->route('admin.list')->with('flash_success','An admin user is deleted');
        }
        return redirect()->route('admin.list')->with('flash_error','User could not be deleted');
    }
}